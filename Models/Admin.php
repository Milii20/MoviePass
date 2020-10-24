<?php
/*Administrador hereda de IUser
Agrega peliculas a un cine en un dia y horario concreto (selecciona cine, despues dia y horario)
administra cines
consulta la cantidad de entradas vendidas y las restantes de cada peli, cine o turno
consulta total en pesos vendidos por cine, pelicula, y-o entre fechas
*/

namespace Models;
Class Admin extends User
{
    //solo se loggea por mail y pass, para facilitar que nadie le robe la pass del fb y de la nada manejan todo un cine
}
?>