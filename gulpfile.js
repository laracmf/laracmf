process.env.DISABLE_NOTIFIER = true;

var elixir = require('laravel-elixir');

stylesPath = 'public/assets/styles/';
scriptsPath = 'public/assets/scripts/';
imagesPath = 'public/assets/images/';

elixir.config.css.outputFolder = stylesPath;
elixir.config.js.outputFolder = scriptsPath;
elixir.config.sourcemaps = false;

elixir(function (mix) {
    mix.copy('resources/assets/images/*', imagesPath);

    mix.copy('resources/assets/css/bootstrap.*.min.css', stylesPath);
    mix.copy('resources/assets/css/select2.min.css', stylesPath);
    mix.copy('resources/assets/css/style.css', stylesPath);

    mix.copy('resources/assets/js/jquery.fileupload.js', scriptsPath);
    mix.copy('resources/assets/js/jquery.iframe-transport.js', scriptsPath);
    mix.copy('resources/assets/js/jquery.ui.widget.js', scriptsPath);
    mix.copy('resources/assets/js/script.js', scriptsPath);
    mix.copy('resources/assets/js/select2.full.min.js', scriptsPath);

    mix.styles(['bootstrap.min.css'], stylesPath + 'bootstrap.default.min.css');
    mix.styles(['bootstrap.min.css', 'bootstrap-theme.min.css'], stylesPath + 'bootstrap.legacy.min.css');

    mix.styles(['cms-main.css'], stylesPath + 'cms-main.css');

    mix.scripts(['cms-timeago.js', 'cms-restfulizer.js', 'cms-carousel.js', 'cms-alerts.js'], scriptsPath + 'cms-main.js');
    mix.scripts(['cms-picker.js'], scriptsPath + 'cms-picker.js');
    mix.scripts(['cms-comment-core.js', 'cms-comment-edit.js', 'cms-comment-delete.js', 'cms-comment-create.js', 'cms-comment-fetch.js', 'cms-comment-main.js'], scriptsPath + 'cms-comment.js');
});
