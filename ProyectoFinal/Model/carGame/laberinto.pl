%%labyrinth()/5
%% Obtener un arreglo con indicaciones (adelante,atras,derecha,izquierda)
%% Entrada : 
%%    Map       : arreglo del laberinto [[w,w,w],[w,e,w],..]
%%    Start     : p(2,0) coordenada inicial de el laberinto
%%    Finish    : p(2,0) coordenada final de el laberinto
%%    Direction : inicial de el punto cardinal (n,s,e,o)
%% Salida
%%    Path      : arreglo con direcciones que resuelven el laberinto

%%
labyrinth(Map, Start, Finish,Direction,Path):-
    labyrinth(Map, Start, Finish,[], [],Solution,Direction),!,
    reverse(Solution,S),
    addStept(S,Go),
    reverseRoute(Go,Return),
    reverse(Return,Rev),
    append(Go,Rev,Path),
    write(Path),
    !,asserta(labyrinth(Map, Start, Finish,Direction,Path)).

labyrinth(_, Finish, Finish,_, Out,Out,_). 
labyrinth(Map, Start, Finish, Positions,Moves,Out,Direction) :-
    move(Move),
    update(Start, Move, NewState,Direction,NewDirection),
    \+ member(NewState, Positions),
    legal(NewState, Map),
    labyrinth(Map, NewState, Finish,[NewState|Positions],[Move|Moves],Out,NewDirection).

%%legal/2
%% Validar si la coordenada ingresada cae en una celda valida de laberinto w/e 
%% Entrada : 
%%    p(X,Y)       : coordenadas
%%    Map          : arreglo del laberinto [[w,w,w],[w,e,w],..]
%% Salida
%%    valor lógico : true / false
legal( p(X,Y), Map) :-
X >= 0, 7>X,
Y >= 0, 7>Y,
get_cell([X,Y], Map, Z),
Z \= w .


%%get_cell/3
%% obtener contenido de la celda "w" o "s" 
%% Entrada : 
%%    [X,Y] : arreglo de coordenadas
%%    Data  : arreglo del laberinto [[w,w,w],[w,e,w],..]
%% Salida
%%    L     : caracter w ó e
get_cell([X,Y], Data,L):-
    nth0(Y,Data,L1),
    nth0(X,L1,L).

%%update/5
%% Obtener la nueva coordenada coordenada segun la orientación hacia adelante/derecha/izquierda
%% Entrada : 
%%    p(X,Y)     : coordenada
%%    adelante   : direccion
%%    o,e,s,n/4    : orientacion
%% Salida
%%    p(X_new,Y) : coordenada al seguir adenalte segun la orientacion
%%    o,e,s,n/5 : orientacion de salida
update(  p(X, Y), adelante, p(X_new,Y)  , o , o) :-
    X_new is X - 1.
update(  p(X, Y), adelante, p(X_new, Y) , e , e) :-
    X_new is X + 1.
update(  p(X, Y), adelante, p(X, Y_new), s , s) :-
    Y_new is Y + 1.
update(  p(X, Y), adelante,  p(X, Y_new), n , n) :-
    Y_new is Y - 1.


update(  p(X,Y), izquierda,p(X, Y_new),e , n ) :-
    Y_new is Y-1.
update(  p(X,Y), izquierda,p(X_new, Y),s , e ) :-
    X_new is X+1.
update(  p(X,Y), izquierda,p(X, Y_new),o , s ) :-
    Y_new is  Y+1.
update(  p(X,Y), izquierda,p(X_new, Y),n , o ) :-
    X_new is X-1.


% derecha
update(  p(X,Y), derecha , p(X, Y_new),e , s ) :-
    Y_new is  Y+1.
update(  p(X,Y), derecha , p(X_new, Y),n , e ) :-
    X_new is X+1.
update(  p(X,Y), derecha , p(X, Y_new),o , n ) :-
    Y_new is Y-1.
update(  p(X,Y), derecha , p(X_new, Y),s , o ) :-
    X_new is X-1.

%addStept/2
%% Obtener el array de direcciones añadiendo el movimiento adelante despues de cada derecha e izquieda 
%% Entrada : 
%%    arreglo/1  : arreglo con direcciones 
%% Salida
%%    arreglo/2  : arreglo con direcciones modificado
addStept([],[]):-!.
addStept([adelante|Xs], [adelante|Ws]):- addStept(Xs,Ws),!.
addStept([derecha|Xs],[derecha,adelante|Ws]):-addStept(Xs,Ws),!.
addStept([izquierda|Xs],[izquierda,adelante|Ws]):-addStept(Xs,Ws),!.

%reverseRoute/2
%% Concatenar el array1 con array de direcciones para volver al punto inicial de reversa
%% Entrada : 
%%    arreglo/1  : arreglo con direcciones 
%% Salida
%%    arreglo/2  : arreglo con direcciones de ida y vuelta
reverseRoute([],[]):-!.
reverseRoute([adelante|Xs],[atras|Ws]):-reverseRoute(Xs,Ws),!.
reverseRoute([derecha|Xs],[izquierda|Ws]):-reverseRoute(Xs,Ws),!.
reverseRoute([izquierda|Xs],[derecha|Ws]):-reverseRoute(Xs,Ws),!.

%Base de conocimiento de movimientos
move(  adelante ).
move(  izquierda ).
move(  derecha ).
