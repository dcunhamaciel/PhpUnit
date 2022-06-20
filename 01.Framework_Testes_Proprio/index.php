<?php

include "auto_loader.php";

$discountCalculator = new DiscountCalculator();

echo $discountCalculator->apply(80) . "\n";
echo $discountCalculator->apply(130) . "\n";
