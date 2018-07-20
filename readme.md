## Back End (Laravel)

### Crear proyecto Laravel
```sh
VBox_da@VBox_da-PC MINGW32 /c/xampp/htdocs

composer create-project --prefer-dist laravel/laravel larticles

cd larticles

VBox_da@VBox_da-PC MINGW32 /c/xampp/htdocs/larticles

```

### Verificar en navegador

http://localhost/larticles/public/

### Crear Virtualhost
c/xampp/apache/conf/extra/httpd-vhosts.conf

```conf
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/larticles/public"
    ServerName larticles.test
</VirtualHost>
```

### Editar archivo con bloc de notas (abrir como administrador)
C:\Windows\System32\drivers\etc\hosts
```conf
127.0.0.1   larticles.test
```

Reiniciar Apache

### Verificar en navegador

http://larticles.test

### Crear Base de Datos (larticles) en PostgreSQL


### Configurar archivo .env
```conf
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=larticles
DB_USERNAME=postgres
DB_PASSWORD=123456
```

### Crear migraciones
```sh
VBox_da@VBox_da-PC MINGW32 /c/xampp/htdocs/larticles

php artisan make:migration create_articles_table --create=articles

> Las opciones --table y --create puden ser usadas para indicar el nombre de la tabla y si la migracion creará o no una nueva tabla.

> ejemplo para hacer cambios a una tabla 
>php artisan make:migration add_votes_to_users_table --table=users
```

#### Agregar campos a la tabla
En database/migrations/XXXX_XX_XX_XXXXXX_create_articles_table.php
```php
    ...
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
    }
    ...
```

### Agregar valores aleatorios, (definir una longitud por defecto)
En app/Providers/AppServiceProvider.php
```php
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Schema::defaultStringLength(191);
    }
```

### Generar valores semilla (seed) aleatorios
```sh
php artisan make:seeder ArticlesTableSeeder
```

En database/seeds/ArticlesTableSeeder.php, crear 30 registros aleatorios de la clase Articles.
```php
    ...
    public function run()
    {
        factory(App\Article::class, 30)->create();
    }
    ...
```

En database/seeds/DatabaseSeeder.php, llamar a ArticlesTableSeeder
```php
    ...
    public function run()
    {
        $this->call(ArticlesTableSeeder::class);
    }
    ...
```

### Crear el molde de los valores para poder fabricar
```sh
php artisan make:factory ArticleFactory
```

En database/factories/ArticleFactory.php, llamar a ArticlesTableSeeder
```php
    ...
$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'body'  => $faker->text(200)
    ];
});
```

### Crear el modelo ORM
```sh
php artisan make:model Article
```

### Ejecutar la migracion de las tablas a la base de datos, con --seed ejecuta las semillas todo de una vez
```sh
php artisan migrate
```
### Ejecutar las semillas
```sh
php artisan db:seed
```

### Crear el Controlador como un resource (permite hacer un CRUD rapidamente)
```sh
php artisan make:controller ArticleController --resource
```

### Crear rutas en routes/api.php
```php
// List articles
Route::get('articles', 'ArticleController@index');
// List single article
Route::get('article/{id}', 'ArticleController@show');
// Create new article
Route::post('article', 'ArticleController@store');
// Update article
Route::put('article', 'ArticleController@store');
// Delete article
Route::delete('article/{id}', 'ArticleController@destroy');
```


### Crear Resource, como se va a generar la respuesta
```sh
php artisan make:resource Article
```

En app/Http/Resources/Article.php
```php
    ...
    public function toArray($request)
    {
        //return parent::toArray($request);
        
        //para no mostrar todos los datos en la respuesta y solo limitar a algunos
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    //para agregar mas datos en la respuesta
    //medium es una api para laravel para crear json api
    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://traversymedia.com')
        ];
    }
```

### Declarar el controlador
En app/Http/Controllers/ArticleController.php, borrar 
create(), muestra el formulario para crear un recurso
edit(), muestra el formulario para editar un recurso
update(), actualiza el recurso en la base de datos, se va a hacer todo desde store()
```php
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

    ...
    //mostrar todos los valores con paginacion
    public function index()
    {
        // Get articles y paginar de a 5 resultados los mas recientes
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    //guardar nuevo o editar segun el metodo post o put
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;
        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        if($article->save()) {
            return new ArticleResource($article);
        }
    }

    //devolver un articulo segun id
    public function show($id)
    {
        // Get article
        $article = Article::findOrFail($id);
        // Return single article as a resource
        return new ArticleResource($article);
    }

    //para eliminar un articulo segun por id
    public function destroy($id)
    {
        // Get article
        $article = Article::findOrFail($id);
        if($article->delete()) {
            return new ArticleResource($article);
        }    
    }
```

Con **`postman`** se puede verificar las llamadas http
[https://www.getpostman.com/apps](https://www.getpostman.com/apps)

get->index
http://larticles.test/api/articles

delete->destroy
http://larticles.test/api/article/1

post->store
header content-type application/json
body {
    "tile": "test title",
    "body": "test body"
}
http://larticles.test/api/article

put->store
header content-type application/json
body {
    "article_id": "1"
    "tile": "test title",
    "body": "test body"
}

get->show
http://larticles.test/api/article/1

Para que el resultado muestre solo un objeto con los valores {id: ...}, y no un objeto data con los valores { data: {id: ...} }

En app/Providers/AppServiceProvider.php
```php
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Schema::defaultStringLength(191);
        // Resource::withoutWrapping();
    }
```

## Front End (Node.js y Vue.js)

En el archivo **`package.json`** se ven las dependencias que vienen preconfiguradas.

Para instalarlas
```sh
npm install
```

Para observar cambios en los archivos y que se transpilen en css y js tendrá a laravel-mix observando y build nuestros archivos todo el tiempo:
```sh
npm run watch
```

### Componente Vue.js
En resources/assets/js/app.js, está la vista principal que inicializa vue
```js
Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('articles', require('./components/Articles.vue'));

const app = new Vue({
    el: '#app'
});
```

En donde el ID **#app** del componente cargara el template declarado en **`resources/assets/js/components/ExampleComponent.vue`**. Esto es un boilerplate (codigo repetitivo de ejemplo)

Pero usaremos la vista **`resources/assets/views/welcome.blade.php`**
En donde colocaremos el ID #app y un tag personalizado del componente
```php
    <head>
        ...
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' };</script>
        ...
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <articles></articles>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
```

### Crear componente Articles.vue

Crear **`resources/assets/js/components/Articles.vue`**

```html
<template>
    <div>
        <h2>Articles</h2>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: ''
            };
        }
    }
</script>
```

### Crear componente Navbar.vue

```html
<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
        <div class="container">
            <a href="#" class="navbar-brand">Larticles</a>
        </div>
    </nav>
</template>
```

#### larticles.test/index
![larticles index](https://user-images.githubusercontent.com/35436943/42975423-6b9b5e1a-8b92-11e8-925f-313e094ff774.jpg)


### Otros

#### larticles.test
![larticles](https://user-images.githubusercontent.com/35436943/42975018-52129046-8b90-11e8-9ab2-e7b3b9a754d3.jpg)


#### larticles.test/api/post
![larticles api articles](https://user-images.githubusercontent.com/35436943/42975766-7bd4a3b6-8b94-11e8-9add-709a6459e8ab.jpg)