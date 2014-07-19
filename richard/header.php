<?php
wp_head();

$RapeCrisisManager = new RapeCrisisManager();

echo "hi";

echo $RapeCrisisManager->getRandomHeaderImageHtml();
