<?php

if(isset($_SESSION["connected"]))
{
    $this->container->view->getEnvironment()->addGlobal('session', $_SESSION["connected"]);
}
else
{
    $this->container->view->getEnvironment()->addGlobal('session', false);
}