<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta http-equiv = "content-type" content = "text/html; charset=UTF-8">
        <title>Composer Autoload e Namespace</title>
        <link href="<?= base_url('/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/font-awesome.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/style.css'); ?>" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo route('painel'); ?>">Painel</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-left">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php $this->loadViewInTemplate($viewFolder,$viewName, $viewData); ?>

        <div class="clearfix"></div>
        <div class="footer">
            <h1></h1>
        </div>


        <script src="<?= base_url('/assets/js/jquery.js'); ?>"></script>
        <script src="<?= base_url('/assets/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript">
            var BASE = '<?php echo base_url(); ?>';
        </script>
        <script src="<?= base_url('/assets/js/ajax.js'); ?>"></script>
    </body>
</html>
