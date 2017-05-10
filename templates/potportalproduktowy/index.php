<?php
defined('_JEXEC') or die;

/* The following line loads the MooTools JavaScript Library */
JHtml::_('behavior.framework', true);

/* The following line gets the application object for things like displaying the site name */
$app = JFactory::getApplication();
$this->setBase('');
?>
<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >

    <head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KVCWKPT');</script>
<!-- End Google Tag Manager -->
        <jdoc:include type="head" />
        <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/templates/<?php echo $this->template; ?>/css/merged.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo JURI::base(true); ?>/modules/mod_imageslider/js/contentflow/contentflow.css" type="text/css" />
        <script type="text/javascript" src="<?php echo JURI::base(true); ?>/modules/mod_imageslider/js/contentflow/contentflow.js"></script>
        <script src="<?php echo JURI::base(true); ?>/media/lightbox/js/jquery-1.7.2.min.js"></script>
        <script src="<?php echo JURI::base(true); ?>/media/lightbox/js/lightbox.js"></script>
        <link href="<?php echo JURI::base(true); ?>/media/lightbox/css/lightbox.css" rel="stylesheet" />
    </head>

    <body id="home">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KVCWKPT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <div id="header">

            <div class="wrapper">

                <table border="0" cellpadding="0" width="100%">
                    <tr align="center">
                        <td width="33%"><a href="<?php echo JURI::base(false); ?>"><img style="margin: 5px 0px 5px 0px" src="images/stories/produktowy/logo/logo-PPD-2016.png" width="247" height="80" /></a></td>
                        <td width="33%"></td>
                        <td width="33%"><a href="http://www.msport.gov.pl/" target="_blank"><img height="60" src="//polska.travel/images/stories/polskatravel/Polska/MSIT_pl.png" alt="MSIT pl"></a></td>
                    </tr>
                </table>

                <div class="fright">

                    <div id="menuMain" class="right">
                        <!-- Main Menu -->
                        <jdoc:include type="modules" name="menu_glowne" style="xhtml" />
                    </div>

                </div>

                <div class="clear"></div>

            </div>

        </div>

        <div id="slider" class="wrapper">
            <!-- Picture slider above content -->
            <jdoc:include type="modules" name="slider" style="xhtml" />
            <div class="clear"></div>
        </div>

        <div id="search" class="wrapper">
            <!-- Product search -->
            <jdoc:include type="modules" name="search" style="xhtml" />
            <div class="clear"></div>    
        </div>


        <div id="content" class="wrapper">

            <?php if ($this->countModules('column_left')): ?>
                <div id="leftColumn" class="fleft">

                    <!-- Lewa kolumna -->
                    <jdoc:include type="modules" name="column_left" style="xhtml" />

                </div>
            <?php endif; ?>

            <?php if ($this->countModules('column_right')): ?>
                <div id="rightColumn" class="fright">

                    <!-- Prawa kolumna -->
                    <jdoc:include type="modules" name="column_right" style="xhtml" />

                </div>
            <?php endif; ?>


            <div id="textCont<?php if (!$this->countModules('column_left | column_right')) echo 'NoSidebar'; ?>">

                <!-- Komponent -->
                <jdoc:include type="component" style="xhtml" />

            </div>

            <div class="clear"><!-- Clear line --></div>

        </div>

        <div id="footerCont">

            <div class="wrapper">

                <table border="0" cellpadding="0" width="100%">
                    <tr align="center" valign="top">
                        <td><jdoc:include type="modules" name="footer" style="xhtml" /></td>
                        <td><img src="images/stories/produktowy/logo/mala.png" height="74" width="530" /></td>
                        <td><span class="copyrights">(c) <?php echo date('Y'); ?> Polska Organizacja Turystyczna</span</td>
                    </tr>
                </table>

                <div class="clear"></div>

            </div>            

        </div>

        <jdoc:include type="modules" name="debug" />

        <script type="text/javascript" src="https://crm.pot.gov.pl/ScriptProvider"></script>
        <script type="text/javascript">
            POTCounter.PreventDefault();
            POTCounter.OnPageLoad(function () {
                POTCounter.ActionURL = "https://crm.pot.gov.pl/SaveActivity";
                POTCounter.SetPageToken("619f94d9-7583-424b-b3f6-77fe6b87d715");
                POTCounter.SendInfo();
            });
        </script>

        <!--HTML LOADED-->
    </body>

</html>
