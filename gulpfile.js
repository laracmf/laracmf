process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');

stylesPath = 'public/assets/styles/';
scriptsPath = 'public/assets/scripts/';
imagesPath = 'public/assets/images/';

elixir.config.css.outputFolder = stylesPath;
elixir.config.js.outputFolder = scriptsPath;
elixir.config.sourcemaps = false;

elixir(function (mix) {
    mix.copy('resources/assets/images/*', imagesPath)
        .copy('resources/assets/css/bootstrap.*.min.css', stylesPath)
        .copy('resources/assets/css/select2.min.css', stylesPath)
        .copy('resources/assets/css/style.css', stylesPath)
        .copy('resources/assets/css/font-awesome.min.css', stylesPath)
        .copy('resources/assets/css/animate.min.css', stylesPath)
        .copy('resources/assets/js/jquery.fileupload.js', scriptsPath)
        .copy('resources/assets/js/jquery.iframe-transport.js', scriptsPath)
        .copy('resources/assets/js/jquery.ui.widget.js', scriptsPath)
        .copy('resources/assets/js/script.js', scriptsPath)
        .copy('resources/assets/js/select2.full.min.js', scriptsPath)
        .copy('resources/assets/js/fileupload-script.js', scriptsPath)
        .copy('resources/assets/js/select-script.js', scriptsPath)
        .copy('resources/assets/js/jquery-3.1.1.min.js', scriptsPath)
        .copy('resources/assets/js/bootstrap.min.js', scriptsPath)
        .copy('resources/assets/js/jquery.timeago.min.js', scriptsPath)

        .styles(['bootstrap.min.css'], stylesPath + 'bootstrap.default.min.css')
        .styles(['bootstrap.min.css', 'bootstrap-theme.min.css'], stylesPath + 'bootstrap.legacy.min.css')

        .scripts([
            'cms-timeago.js',
            'cms-restfulizer.js',
            'cms-carousel.js',
            'cms-alerts.js'
        ], scriptsPath + 'cms-main.js')
        .scripts([
            'cms-comment-core.js',
            'cms-comment-edit.js',
            'cms-comment-delete.js',
            'cms-comment-create.js',
            'cms-comment-fetch.js',
            'cms-comment-main.js'
        ], scriptsPath + 'cms-comment.js')

        .scripts([
            'jquery-3.1.1.min.js',
            'jquery.ui.widget.js',
            'jquery.fileupload.js',
            'jquery.timeago.min.js',
            'bootstrap.min.js',
            'jquery.iframe-transport.js',
            'select2.full.min.js',
            'fileupload-script.js',
            'select-script.js',
            'cms-timeago.js',
            'cms-restfulizer.js',
            'cms-carousel.js',
            'cms-alerts.js',
            'script.js'
        ], scriptsPath + 'all.js')

        .styles([
            'bootstrap.min.css',
            'bootstrap-theme.min.css',
            'font-awesome.min.css',
            'animate.min.css',
            'select2.min.css',
            'cms-main.css',
            'style.css'
        ], stylesPath + 'all.css')
        .version([stylesPath + 'all.css', scriptsPath + 'all.js'])
        .stylesIn(stylesPath);
});
