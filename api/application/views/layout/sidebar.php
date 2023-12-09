<?php
$segment=$this->uri->segment(3); 
$segment2=$this->uri->segment(2);

?>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title logoWrapper" style="border: 0;">    
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <!-- <div class="profile">
      <div class="profile_pic">
        <img src="<?php echo base_url(); ?>assests/images/user.jpg" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2>Admin</h2>
      </div>
    </div> -->
    <div class="clearfix"></div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section active">
        <h3 class="hidden">General</h3>
        <ul class="nav side-menu">
          <li><a href="<?php echo base_url("dashboard"); ?>"><i class="fa fa-tachometer"></i> Dashboard</a>            
          </li>
         <li><a href="<?php echo base_url("user"); ?>"><i class="fa fa-user"></i> Users</a></li>
          
          <li>
            <a href="<?php echo base_url("promocode"); ?>"><i class="fa fa-money"></i>Promo Code</a>
          </li> 
          <li <?php if($segment2 == 'filterby'){ echo 'class="active"';} ?>>
             <a><i class="fa fa-fax" aria-hidden="true"></i>Fax <span class="fa fa-chevron-down"></span></a>
             <ul class="nav child_menu" <?php if($segment2 == 'filterby'){ echo 'style="display:block"';} ?>>
                <li <?php if($segment == 'all'){ echo 'class="current-page"';} ?>><a href="<?php echo base_url("fax"); ?>/fax_shorting/all">All</a></li>
                <li <?php if($segment == 'sent'){ echo 'class="current-page"';} ?>><a href="<?php echo base_url("fax"); ?>/fax_shorting/sent">Sent</a></li>
                <?php /*<li <?php if($segment=""){?>class="current-page" <?php }?>><a href="<?php echo base_url("fax"); ?>/fax_shorting/draft">Draft</a></li>*/ ?>
                <li <?php if($segment == 'failed'){ echo 'class="current-page"';} ?>><a href="<?php echo base_url("fax"); ?>/fax_shorting/failed">Failed</a></li>
             </ul>
          </li> 

          <li>
             <a><i class="fa fa-cc-mastercard" aria-hidden="true"></i>Payment<span class="fa fa-chevron-down"></span></a>
             <ul class="nav child_menu">
               <li <?php if($segment=""){ echo 'class="current-page"'; } ?> ><a href="<?php echo base_url("payment"); ?>/payment_shorting/all">All</a></li>
              <li <?php if($segment=""){ echo 'class="current-page"';  }?>><a href="<?php echo base_url("payment"); ?>/payment_shorting/charged">Charged</a></li>
              <li <?php if($segment=""){?>class="current-page" <?php }?>><a href="<?php echo base_url("payment"); ?>/payment_shorting/payment_declined">Payment Decline</a></li>
              
             </ul>
          </li> 
          <li>
            <a href="<?php echo base_url("setting"); ?>"><i class="fa fa-cog"></i>Settings</a>
          </li> 
          <!--<li>-->
          <!--  <a href="<?php echo base_url("promocodemaster"); ?>"><i class="fa fa-money"></i>Promo Code Master</a>-->
          <!--</li> -->
          <li>
            <a href="<?php echo base_url("credits"); ?>"><i class="fa fa-credit-card"></i>Credits</a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo base_url(); ?>assests/images/logo_transparent.png" alt="">Admin
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">

            <li class="hidden">
              <a href="javascript:;">

                <span>Settings</span>
              </a>
            </li>
            <li><a href="<?php echo base_url("user/logout"); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->
