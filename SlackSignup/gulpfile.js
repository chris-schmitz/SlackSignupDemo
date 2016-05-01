var elixir = require('laravel-elixir');
var gulp = require('gulp')

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
        .browserify('app.js', 'public/js/bundle.js')

})

gulp.task('copyfonts', function (){
    gulp.src('./node_modules/font-awesome/fonts/**/*')
        .pipe(gulp.dest('public/fonts'))
})
