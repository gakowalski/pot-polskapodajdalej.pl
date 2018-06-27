<?php
defined('_JEXEC') or die;

$app      = JFactory::getApplication();
$user     = JFactory::getUser();
$doc      = JFactory::getDocument();
$lang     = JFactory::getLanguage();
$menu     = $app->getMenu();
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$cookie   = $app->input->cookie;

$frontpage_enabled = ($menu->getActive() == $menu->getDefault($lang->getTag()));
$template_path = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);
$this->setHtml5(true);
$this->setBase('');

$doc->addStyleSheet($template_path . '/css/default.css');
//$doc->addScript($template_path . '/js/default.js');
$body_classes =
  'site '
  . $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
  . ($this->direction === 'rtl' ? ' rtl' : '')
  . ($frontpage_enabled == true? ' frontpage' : ' not-frontpage');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <jdoc:include type="head" />
    </head>

    <body id="home" class="<?php echo $body_classes; ?>">
        <div id="header">
            <div class="wrapper">
                <div class="logos">
                  <div><a href="https://polskapodajdalej.pl/"><img style="margin: 8px 0px 8px 0px" src="/images/frontpage/CERTYFIKAT%202018%20PL.png" width="247" height="91"></a></div>
                  <div><a href="https://www.msit.gov.pl/" target="_blank"><img src="//polska.travel/images/pl-PL/logotypy/msit_220x55.jpg" alt="MSIT pl"></a></div>
                </div>

                <div id="menuMain">
                    <jdoc:include type="modules" name="menu_glowne" style="none" />
                </div>
            </div>
        </div>

        <?php if ($this->countModules('slider')): ?>
        <div id="slider" class="wrapper">
            <!-- Picture slider above content -->
            <jdoc:include type="modules" name="slider" style="none" />
            <div class="clear"></div>
        </div>
        <?php endif; ?>

        <?php if ($this->countModules('search')): ?>
          <div id="search" class="wrapper">
              <!-- Product search -->
              <jdoc:include type="modules" name="search" style="none" />
              <div class="clear"></div>
          </div>
        <?php endif; ?>


        <div id="content" class="wrapper">
            <div id="textContNoSidebar">
                <jdoc:include type="component" style="none" />
            </div>
            <div class="clear"></div>
        </div>

        <div id="footerCont">
            <div class="wrapper">
                <p><img src="images/stories/produktowy/logo/mala.png" height="74" width="530" /></p>
                <p><span class="copyrights">&copy; <?php echo date('Y'); ?> Polska Organizacja Turystyczna</span></p>
                <jdoc:include type="modules" name="footer" style="none" />
            </div>
        </div>

        <jdoc:include type="modules" name="debug" />
    </body>
</html>
