var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

var assets = "resources/assets/";
var bower = "bower/";
var paths = {
    'adminlte': bower + 'AdminLTE/',
    // 'bootstrap': bower + 'bootstrap/dist/',
  	'bootstrap': bower + 'AdminLTE/bootstrap/',
    'fontawesome': bower + 'font-awesome/',
    'ionicons': bower + 'Ionicons/',
    // 'datatables': bower + 'datatables/media/',
    'datatables': bower + 'AdminLTE/plugins/datatables/',
    'sweetalert': bower + 'sweetalert/dist/',
}

elixir(function(mix) {
    mix.copy(assets + paths.bootstrap + 'fonts/**', 'public/build/fonts')
        .copy(assets + paths.fontawesome + 'fonts/**', 'public/build/fonts')
        .copy(assets + paths.ionicons + 'fonts/**', 'public/build/fonts')
        .styles([
            paths.bootstrap + "css/bootstrap.css",
            paths.fontawesome + "css/font-awesome.css",
            paths.ionicons + "css/ionicons.css",
            paths.datatables + "dataTables.bootstrap.css",
            paths.adminlte + "dist/css/AdminLTE.css",
            paths.adminlte + "dist/css/skins/_all-skins.min.css",
            paths.adminlte + "plugins/iCheck/flat/blue.css",
            paths.sweetalert + "sweetalert.css",
            "css/custom.css",
        ], "public/css/theme.css", assets)
        .scripts([
            bower + "jquery/dist/jquery.min.js",
            paths.bootstrap + "js/bootstrap.min.js",
            paths.datatables + "jquery.dataTables.min.js",
            paths.datatables + "dataTables.bootstrap.min.js",
            // paths.datatables + "extensions/Responsive/js/dataTables.responsive.min.js",
            paths.adminlte + "plugins/iCheck/icheck.min.js",
            paths.adminlte + "plugins/slimScroll/jquery.slimscroll.min.js",
            paths.adminlte + "plugins/fastclick/fastclick.min.js",
            paths.adminlte + "dist/js/app.min.js",
            paths.sweetalert + "sweetalert.min.js",
            bower + "jquery-fullscreen/jquery.fullscreen-min.js",
            "js/custom.js",
        ], 'public/js/theme.js', assets)
        .version(['css/theme.css','js/theme.js'])
});

