import express		from 'express';
import phpExpress	from 'php-express';

const PORT	= 3000;
const app	= express();

const appPhp = phpExpress({
  binPath: 'php'
});

// set view engine to php-express
app.set('views', './views');
app.engine('php', appPhp.engine);
app.set('view engine', 'php');

app.use(express.static('./views/assets'));
app.all(/.+\.php$/, appPhp.router);

app.listen(PORT, function () {
  console.log(`Escuchando en http://localhost:${PORT}`);
});