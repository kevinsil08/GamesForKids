const CELL_SIZE = 25;
const CELL_GAP = 2;
var id_selected = 0;
// group of cells 
class Grid{
    #cells;
    #functionNumber;
    #rowSize
    #colSize
    constructor(gridElement,rowSize , colSize){
        this.#rowSize = rowSize;
        this.#colSize = colSize;
        gridElement.style.setProperty("--grid-col-size", rowSize);
        gridElement.style.setProperty("--grid-row-size", colSize);
        gridElement.style.setProperty("--cell_size",`${CELL_SIZE}vmin`);
        gridElement.style.setProperty("--cell-gap",`${CELL_GAP}vmin`);
        this.#functionNumber = 0;
        this.#cells = createCellElements(gridElement , rowSize , colSize).map((cellElement,index) =>{
            return new Cell(index , cellElement, index % rowSize , Math.floor(index/colSize));
        });
    }

    get allCells(){
        return this.#cells;
    }

    set fnNumber(number){
        this.#functionNumber = number;
    }
    get currentFnNum(){
        return this.#functionNumber;
    }

    cellById(idS){
        return this.#cells.find(cell => cell.id == idS);   
    }
    cellByCord(x,y){
        return this.#cells.find(cell => cell.x == x && cell.y ==y);
    }
    increaseFnNumber() {
       this.#functionNumber++; 
    }

    getInitialCell(){
        return  this.#cells.find(cell => cell.inicial == true);   

    }
    getFinalCell(){
        return  this.#cells.find(cell => cell.final == true);   
    }
    // query string for prolog 
    getPrologQuery(){
        let query = "labyrinth([";
        let index = 0;
        let startCoordinate , finalCoordinate ;
        let orientation = this.getInitialCell().carTile.orientation;
        for (let i = 0; i < this.#rowSize; i++) {
            let rowQuery = "["
            let letter 
            for (let j = 0; j < this.#colSize; j++, index++) {
                letter = ( this.#cells[index].ruta || this.#cells[index].inicial|| this.#cells[index].final )  ? "e," : "w," ;
                if (this.#cells[index].inicial) startCoordinate  = this.#cells[index].getCoordinate() ;
                if (this.#cells[index].final) finalCoordinate  = this.#cells[index].getCoordinate() ;
                rowQuery += letter
            }
            rowQuery = rowQuery.slice(0,-1) + "],"
            query += rowQuery
        }
        query = query.slice(0,-1) + "]"
        return query + "," + startCoordinate + "," + finalCoordinate + "," + orientation + ",S).";
    }



}
// div cell of grid
class Cell {
    #inicial
    #x
    #y
    #final
    #ruta
    #cellElement
    #id
    #carTile
    constructor(id ,cellElement , x , y){
        this.#id = id;
        this.#cellElement = cellElement;
        this.#x = x;
        this.#y = y;
        this.#inicial = false;
        this.#final = false;
        this.#ruta = false;
    }

    set inicial(value){
        if (value && !this.#final) {
            this.#inicial = value;
            this.#cellElement.classList.remove("cell");
            this.#cellElement.classList.add("cell-initial");
        } else {
            this.#inicial = false;
        }            
    }

    set final(value){
        if (value && !this.#inicial) {
            this.#final = value;
            this.#cellElement.classList.remove("cell");
            this.#cellElement.classList.add("cell-final");
        } else {
            this.#final = false;
        }
    }
    set ruta(value){
        if (value && !this.#inicial && !this.#final) {
            this.#ruta = value;
            this.#cellElement.classList.remove("cell");
            this.#cellElement.classList.add("cell-path");
        } else {
            this.#ruta = false;
        }
    }

    set carTile(value){
        this.#carTile = value;
        if (value == null) return
        this.#carTile.x = this.#x ;
        this.#carTile.y = this.#y ;
    }

    get carTile(){
        return this.#carTile;
    }

    get inicial(){
        return this.#inicial;
    }

    get final(){
        return this.#final;
    }
    get ruta(){
        return this.#ruta;
    }
    get divElement(){
        return this.#cellElement;
    }

    get id(){
        return this.#id;
    }

    get x(){
        return this.#x;
    }

    get y(){
        return this.#y;
    }

    getCoordinate(){
        return "p(" + this.#x  + "," + this.#y + ")"
    }

    shakeCell(){
        this.#cellElement.classList.toggle("shake");
    }

}

// container of car element
class CarTile{
    #tileElement
    #imgElement
    #x
    #y
    #orientation
    #angle
    #cardinalPoints
    constructor(tileContainer, carSource){ // titleContainer is the div elements / carSource is src of car.png
        this.#tileElement = document.createElement("div");
        this.#tileElement.classList.add("carTile","img-rotate");
        tileContainer.append(this.#tileElement)
        this.#imgElement = document.createElement("img");
        // this.#imgElement.classList.add("img-rotate");
        this.#imgElement.style.setProperty("width",`${CELL_SIZE - 6}vmin`);
        this.#imgElement.style.setProperty("height",`${CELL_SIZE - 3}vmin`);
        this.#imgElement.src = carSource;
        this.#tileElement.appendChild(this.#imgElement);
        this.#angle = 0;
        this.#cardinalPoints = ["n","e","s","o"];
        this.orientation = "n";
    }
    // set cordinates into board game div
    set x(value){
        this.#x=value;
        this.#tileElement.style.setProperty("--x",value)
    }
    set y(value){
        this.#y=value;
        this.#tileElement.style.setProperty("--y",value)
    }
    // n,s,e,o
    set orientation(value){
        this.#orientation = value
    }
    get orientation(){
        return this.#orientation;
    }

    get x(){
        return this.#x;
    }
    get y(){
        return this.#y;
    }
    // movemenet functions
    rotateR(){
        // rotate img
        this.#angle += 90;
        this.#tileElement.style.transform = "rotate("+ this.#angle+"deg)";
        // set orientation 
        let firstElement = this.#cardinalPoints.shift();
        this.#cardinalPoints.push(firstElement);
        this.#orientation = this.#cardinalPoints[0];
    }

    rotateL(){
        this.#angle -= 90;
        this.#tileElement.style.transform = "rotate("+ this.#angle+"deg)";
        let lastElement = this.#cardinalPoints.pop();
        this.#cardinalPoints.unshift(lastElement);
        this.#orientation = this.#cardinalPoints[0];
    }

    goForward(){
        switch (this.#orientation) {
            case "n":        
                this.#y = this.#y - 1;
                this.#tileElement.style.setProperty("--y",this.#y)
                break;
            case "e":        
                this.#x = this.#x + 1;
                this.#tileElement.style.setProperty("--x",this.#x)
                break;
            case "s":        
                this.#y = this.#y + 1;
                this.#tileElement.style.setProperty("--y",this.#y)
                break;
            case "o":        
                this.#x = this.#x - 1;
                this.#tileElement.style.setProperty("--x",this.#x)
                break;

            default:
                break;
        }
    }
    
    goBackward(){
        switch (this.#orientation) {
            case "n":        
                this.#y = this.#y + 1;
                this.#tileElement.style.setProperty("--y",this.#y)
                break;
            case "e":        
                this.#x = this.#x - 1;
                this.#tileElement.style.setProperty("--x",this.#x)
                break;
            case "s":        
                this.#y = this.#y - 1;
                this.#tileElement.style.setProperty("--y",this.#y)
                break;
            case "o":        
                this.#x = this.#x + 1;
                this.#tileElement.style.setProperty("--x",this.#x)
                break;

            default:
                break;
        }
    }

    delete(){
        this.#tileElement.remove();
    }
}

class LabyrinthGame{
    #directions
    #numberCommands
    #numberError
    #timeSession
    #currentDirection
    #indexDir
    constructor(directions){
        this.#directions = directions;
        this.#numberCommands = directions.indexOf('ATRAS');
        this.#numberError = 0;
        this.#timeSession = 0;
        this.#currentDirection = 0;
        this.indexDir  = 0;
    }

    set directions(directions){
        this.#directions = directions;
    }

    get directions(){
        return this.#directions
    }

    set numberError(numberErrors){
        this.#numberError= numberErrors
    }

    get numberError(){
        return this.#numberError
    }

    get currentDirection(){
        return this.#directions[this.#indexDir]
    }

    set indexDir(index){
        this.#indexDir = index
    }

    get indexDir(){
        return this.#indexDir
    }
    
    increaseIndexDir() {
        this.#indexDir++;    
    }

    increaseError(){
        this.#numberError++;
    }
} 

function createCellElements(gridElement , rowSize , colSize){
    const cells = [];
    for (let index = 0; index < rowSize * colSize ; index++) {
        const cell = document.createElement("div");
        cell.classList.add("cell");
        cell.setAttribute('id',`${index}`);
        cells.push(cell);
        cell.addEventListener('click',function(e){
            printInfo(e.target);
        });
        gridElement.append(cell);
    }
    return cells;
}

function printInfo(elem){
    id_selected = elem.id;
    // elem.classList.remove("cell");
    // elem.style.backgroundColor = "red";
    // console.log(id_selected) ;
}


