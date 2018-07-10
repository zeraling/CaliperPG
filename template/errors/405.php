<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Caliper - 404 Error Page</title>
        <link rel="shortcut icon" href="<?= BASE_URL ?>template/images/logoMini.png">
        <meta name="description" content="404 Error Page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?= BASE_URL ?>template/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= BASE_URL ?>plugins/font-awesome/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="<?= BASE_URL ?>template/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?= BASE_URL ?>template/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="template/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="<?= BASE_URL ?>template/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?= BASE_URL ?>template/css/ace-ie.min.css" />
        <![endif]-->

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->
        <!--[if lte IE 8]>
        <script src="<?= BASE_URL ?>template/js/html5shiv.min.js"></script>
        <script src="<?= BASE_URL ?>template/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default navbar-collapse h-navbar ace-save-state nav-header-bg-cr">
            <div class="navbar-container ace-save-state" id="navbar-container">
                 <div class="navbar-header pull-left">
                    <a href="<?= BASE_URL ?>" class="navbar-brand">
                        <small><span>¡</span><b> Caliper </b><span>!</span></small>
                    </a>
                </div>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container ace-save-state" id="main-container">
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->

                                <div class="error-container">
                                    <div class="well">
                                        <h1 class="grey lighter smaller">
                                            <span class="blue bigger-125">
                                                <i class="ace-icon fa fa-sitemap"></i>
                                                405
                                            </span>
                                            Method Not Allowed
                                        </h1>
                                        <div>
                                            <div class="well">
                                                La petición realizada no se encuentra definida dentro del sistema
                                            </div>
                                        </div>
                                        <hr />
                                        <h3 class="lighter smaller">
                                            <pre>
                                                <?php echo $errorExp ?>
                                            </pre>
                                            
                                        </h3>
                                        <hr />
                                        <div class="space"></div>

                                        <div class="center">
                                            <a href="javascript:history.back()" class="btn btn-grey">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                Go Back
                                            </a>

                                            <a href="<?= BASE_URL ?>" class="btn btn-primary">
                                                <i class="ace-icon fa fa-home"></i>
                                                Incio
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="red bolder">Sigledo</span><b> &copy; <?=date('Y')?> Radproct Ltda.</b>
                        </span>
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
    </body>
</html>
