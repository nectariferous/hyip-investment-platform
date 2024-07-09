<?php

header("Content-Type:text/css");

$primary_color = '#' . $_GET['primary_color'];
?>

:root {
    --clr-main: <?php echo $primary_color; ?>;
}

.feature-box .content {
    box-shadow: inset 0 0px 66px <?php echo $primary_color; ?>47;
}

.invest-plan-top::before {
    box-shadow: inset 0 0px 66px <?php echo $primary_color; ?>d4;
}

.invest-plan::before {
    box-shadow: inset 0 0px 66px <?php echo $primary_color; ?>3b;
}

.invest-plan-shape::after {
    background-color: <?php echo $primary_color; ?>33;
}

.invest-plan:hover .invest-plan-shape::after {
    background-color: <?php echo $primary_color; ?>;
}

.work-box {
    box-shadow: inset 0 0px 20px <?php echo $primary_color; ?>c4;
}

.work-box .icon {
    box-shadow: inset 0 0px 20px <?php echo $primary_color; ?>c4;
}

.cmn-table.style-separate tbody tr {
    box-shadow: inset 0 0px 8px <?php echo $primary_color; ?>4d;
}

.testimonial-box .content {
    box-shadow: inset 0 0px 20px <?php echo $primary_color; ?>c4;
}

.referral-box::before {
    box-shadow: inset 0 0px 20px <?php echo $primary_color; ?>c4;
}

.referral-box-step {
    box-shadow: inset 0 0px 6px <?php echo $primary_color; ?>9e;
}

.choose-wrapper .choose-wrapper-thumb .thumb-inner {
    box-shadow: 0 5px 25px <?php echo $primary_color; ?>59;
}

.choose-wrapper-inner .choose-item .icon {
    box-shadow: inset 0px 5px 9px <?php echo $primary_color; ?>4d;
}

.pricing-item .icon {
    box-shadow: inset 0 0 10px <?php echo $primary_color; ?>59;
}

.pricing-item .plan-name span {
    background-color: <?php echo $primary_color; ?>26;
}

.referral-item .rate {
    box-shadow: 0 0 0 8px <?php echo $primary_color; ?>40;
}