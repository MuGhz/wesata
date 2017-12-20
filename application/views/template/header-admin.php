<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Gis</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .base-background {background-color:#009688;}
.white {color:#ffffff;}

      .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
color: white;  /*Sets the text hover color on navbar*/
}

.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active >   
 a:hover, .navbar-default .navbar-nav > .active > a:focus {
color: white; /*BACKGROUND color for active*/
background-color: #01665c;
}

  .navbar-default {
    background-color: #009688;
    border-color: #01665c;
}

  .dropdown-menu > li > a:hover,
   .dropdown-menu > li > a:focus {
    color: #262626;
   text-decoration: none;
  background-color: #01665c;  /*change color of links in drop down here*/
   }

 .nav > li > a:hover,
 .nav > li > a:focus {
    text-decoration: none;
    background-color: #01665c; /*Change rollover cell color here*/
  }


  .navbar-default .navbar-nav > li > a {
   color: white; /*Change active text color here*/
    }

    .panel-primary>.panel-heading {
    color: #fff;
    background-color: #009688; 
    /* border-color: #337ab7; */
}
    </style>
  </head>
  <body>
      <nav class="navbar navbar-default" role="navigation" style="background-color: #009688;">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">We-sata</a></li>
              <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="glyphicon glyphicon-list"></span> Data <b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                      <li><?php echo anchor('wisata','Wisata') ?></li>
                      <li><?php echo anchor('kategori','Kategori') ?></li>
                      <li><?php echo anchor('review','Review') ?></li>
                      <li><?php echo anchor('peak_time','Peak Time') ?></li>
                      <li><?php echo anchor('pengguna','Pengguna') ?></li>
                      <li><?php echo anchor('hotel','Hotel') ?></li>
                  </ul>
              </li>
              <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="glyphicon glyphicon-globe"></span> Koordinat <b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                      <li><?php echo anchor('kordinat_wisata','Koordinat Wisata') ?></li>
                      <li><?php echo anchor('kordinat_hotel','Koordinat Hotel') ?></li>
                  </ul>
              </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
      <!--header admin-->