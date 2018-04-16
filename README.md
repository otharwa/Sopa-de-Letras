### Sopa de letras

Para instalar el servidor:
dentro de la carpeta del proyecto   
`npm i`


Instalar dependencias globales:   
`sudo npm i -g babel-cli nodemon`


Ejectuar servidor en http://localhost:3000   
`npm start`


-----------------------------------


### Objetivo

Hacer un programa que, para una sopa de letras dada, escriba cuantas veces aparece la
palabra "OIE" dentro de ella, ya sea horizontalmente, verticalmente, o en diagonal. (En total,
hay que comprobar 8 sentidos diferentes.)

### Entrada

La entrada consiste en seleccionar una de las matrices del “listado de matrices” en un select
y enviar el request al servidor.

### Salida

Para cada sopa de letras, hay que escribir cuantas veces aparece "OIE" dentro de ella.

### Listado de matrices
#### 3 3
OIE   
IIX   
EXE   

#### 1 10

EIOIEIOEIO   

#### 5 5

EAEAE   
AIIIA   
EIOIE   
AIIIA   
EAEAE   

#### 7 2

OX   
IO   
EX   
II   
OX   
IE   
EX   