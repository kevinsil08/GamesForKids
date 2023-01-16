get_cell([R,C], Data,L):-
    nth0(R,Data,L1),
    nth0(C,L1,L).

labyrinth(Map, Start, Finish,Direction,Path):-
    labyrinth(Map, Start, Finish,[], [],Solution,Direction),!,
    reverse(Solution,S),
    addStept(S,Go),
    reverseRoute(Go,Return),
    reverse(Return,Rev),
    append(Go,Rev,Path),
    write(Path),
    !.

labyrinth(_, Finish, Finish,_, Out,Out,_). 
labyrinth(Map, Start, Finish, Positions,Moves,Out,Direction) :-
move(Move),
update(Start, Move, NewState,Direction,NewDirection),
\+ member(NewState, Positions),
legal(NewState, Map),
labyrinth(Map, NewState, Finish,[NewState|Positions],[Move|Moves],Out,NewDirection).

legal( p(X,Y), Map) :-
X >= 0, 7>X,
Y >= 0, 7>Y,
get_cell([X,Y], Map, Z),
Z \= w .

% adelante
update(  p(X, Y), adelante, p(X_new,Y)  , n , n) :-
    X_new is X - 1.
update(  p(X, Y), adelante, p(X_new, Y) , s , s) :-
    X_new is X + 1.
update(  p(X, Y), adelante, p(X, Y_new), e , e) :-
    Y_new is Y + 1.
update(  p(X, Y), adelante,  p(X, Y_new), o , o) :-
    Y_new is Y - 1.


% izquierda
update(  p(X,Y), izquierda,p(X, Y_new),n , o ) :-
    Y_new is Y-1.
update(  p(X,Y), izquierda,p(X_new, Y),o , s ) :-
    X_new is X+1.
update(  p(X,Y), izquierda,p(X, Y_new),s , e ) :-
    Y_new is  Y+1.
update(  p(X,Y), izquierda,p(X_new, Y),e , n ) :-
    X_new is X-1.


% derecha
update(  p(X,Y), derecha , p(X, Y_new),n , e ) :-
    Y_new is  Y+1.
update(  p(X,Y), derecha , p(X_new, Y),e , s ) :-
    X_new is X+1.
update(  p(X,Y), derecha , p(X, Y_new),s , o ) :-
    Y_new is Y-1.
update(  p(X,Y), derecha , p(X_new, Y),o , n ) :-
    X_new is X-1.

addStept([],[]):-!.
addStept([adelante|Xs], [adelante|Ws]):- addStept(Xs,Ws),!.
addStept([derecha|Xs],[derecha,adelante|Ws]):-addStept(Xs,Ws),!.
addStept([izquierda|Xs],[izquierda,adelante|Ws]):-addStept(Xs,Ws),!.

reverseRoute([],[]):-!.
reverseRoute([adelante|Xs],[atras|Ws]):-reverseRoute(Xs,Ws),!.
reverseRoute([derecha|Xs],[izquierda|Ws]):-reverseRoute(Xs,Ws),!.
reverseRoute([izquierda|Xs],[derecha|Ws]):-reverseRoute(Xs,Ws),!.

move(  adelante ).
move(  izquierda ).
move(  derecha ).
