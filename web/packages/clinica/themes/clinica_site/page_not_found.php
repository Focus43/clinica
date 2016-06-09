<?php
if( !($this->controller instanceof ClinicaPageController) ){
  $htmlHelper = Loader::helper('html');
  // header and CSS items
  $this->addHeaderItem( '<meta id="clinicaToolsDir" value="'.CLINICA_TOOLS_URL.'" />' );
  $this->addHeaderItem( $htmlHelper->css('clinica.app.css', 'clinica') );
  $this->addHeaderItem( $htmlHelper->javascript('libs/modernizr.min.js', 'clinica') );
  
  // ie8 stylesheet
  $ie8 = "<!--[if lt IE 9]>\n" . $htmlHelper->css('ie8.css', 'clinica') . "\n<![endif]-->";
  $this->addHeaderItem( $ie8 );
  
  // footer stuff (usually javascript)
  $this->addFooterItem( $htmlHelper->javascript('libs/bootstrap.min.js', 'clinica') );
  $this->addFooterItem( $htmlHelper->javascript('clinica.app.js', 'clinica') );
}
?>
<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='//fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />
    <?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
    <?php Loader::packageElement('modernizr', 'clinica'); ?>
</head>

<!-- Enjoy checking out what's under the hood? We should talk! www.focus-43.com -->

<body class="clinicaPage fullWidth">
  
  <div id="minHeighter">
    <?php Loader::packageElement('theme_header', 'clinica'); ?>
    <div class="container">
      <div class="row">
        <div class="span12">
          <div id="cPrimary">
            
            <div class="container-fluid" style="padding:0;">
              <div class="row-fluid">
                <div class="span3">

                </div>
                <div class="span9">
                  <div id="pageTitle">
                    <div class="span12">
                      <h1><?php echo Page::getCurrentPage()->getCollectionName(); ?> <br><small class="visible-desktop">Here are a few other options:</small></h1>
                    </div>
                  </div>
                  <div class="main-content">
                    <?php
                      $bt = BlockType::getByHandle('autonav');
                      $bt->controller->orderBy = 'display_asc';                    
                      $bt->controller->displayPages = 'top';
                      $bt->controller->displaySubPages = 'all';     
                      $bt->controller->displaySubPageLevels = 'all';                    
                      $bt->render('view');                    
                    ?>
                    <br>
                  </div>

                </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="pushFooter"></div>
  </div>
  
  <?php Loader::packageElement('theme_footer', 'clinica', array('c' => $c)); ?>
    <?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>