
<!DOCTYPE html>
<html lang="th">
	<head>
		<meta charset="utf-8" />

		<title><?php echo $this->title; ?></title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=10.0" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.ico">

		<?php $this->load->view('include/header_include'); ?>

		<style>
			.ui-helper-hidden-accessible {
				display:none;
			}

			.ui-autocomplete {
		    max-height: 250px;
		    overflow-y: auto;
		    /* prevent horizontal scrollbar */
		    overflow-x: hidden;
			}

			.ui-widget {
				width:auto;
			}
	</style>
	</head>
	<body class="no-skin" onload="checkError()">

		<div id="loader">
        <div class="loader"></div>
		</div>
		<div id="loader-backdrop" style="position: fixed; width:100vw; height:100vh; background-color:white; opacity:0.3; display:none; z-index:9;">
		</div>

		<?php if($this->session->flashdata('error')) : ?>
							<input type="hidden" id="error" value="<?php echo $this->session->flashdata('error'); ?>" />
		<?php endif; ?>
		<?php if($this->session->flashdata('success')) : ?>
							<input type="hidden" id="success" value="<?php echo $this->session->flashdata('success'); ?>" />
		<?php endif; ?>
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				var BASE_URL = '<?php echo base_url(); ?>';
				var HOME = '<?php echo $this->home; ?>/';
			</script>
			<div class="navbar-container" id="navbar-container">
				<?php if(! isset($_GET['nomenu'])) : ?>
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php endif; ?>
				<div class="navbar-header pull-left">
					<a href="<?php echo ((empty($approve_view) && !isset($_GET['nomenu']) && !$this->isViewer) ? base_url() : '#'); ?>" class="navbar-brand" style="min-width:167px;">
						<small>
							<?php echo getConfig('COMPANY_NAME'); ?>
						</small>
					</a>
				</div>
				<?php if(! isset($_GET['nomenu'])) : ?>
					<?php
					if(!$this->isViewer)
					{
						$this->load->view('include/top_menu');
					}
					?>
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="salmon">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">

								<span class="user-info">
									<small>Welcome</small>
									<?php echo get_cookie('displayName'); ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-caret dropdown-close">
								<?php if(!$this->isViewer) : ?>
								<li>
									<a href="JavaScript:void(0)" onclick="changeUserPwd('<?php echo get_cookie('uname'); ?>')">
										<i class="ace-icon fa fa-keys"></i>
										เปลี่ยนรหัสผ่าน
									</a>
								</li>
								<li class="divider"></li>
								<?php endif; ?>
								<li>
									<a href="<?php echo base_url(); ?>users/authentication/logout">
										<i class="ace-icon fa fa-power-off"></i>
										ออกจากระบบ
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			<?php else : ?>
					<button type="button" class="close margin-top-10" onclick="window.close()"><i class="fa fa-times"></i></button>
				<?php endif; ?>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<?php if(! isset($_GET['nomenu'])) : ?>
			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive <?php echo get_cookie('sidebar_layout'); ?>" data-sidebar="true" data-sidebar-scoll="true" data-sidebar-hover="true">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
						<!--- side menu  ------>
				<?php if($this->isViewer === FALSE) : ?>
				<?php $this->load->view("include/side_menu"); ?>
				<?php endif; ?>

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse" onclick="toggle_layout()">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

			</div>
			<?php endif; ?>
			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse" data-sidebar="true" data-sidebar-scoll="true"
					data-sidebar-hover="true" aria-expanded="false" style="height:1px;">
      <!-- second sidebar, horizontal -->
				<?php

				// if(!$this->isViewer && !isset($_GET['nomenu']))
				// {
				// 	$this->load->view('include/approve_form');
				// 	$this->load->view('include/top_menu');
				// }
				 ?>
    			</div>
                <?php if($this->session->flashdata("error") != null) :?>
					<input type="hidden" id="error" value="<?php echo $this->session->flashdata("error"); ?>">
                <?php elseif( $this->session->flashdata("success") != null ) : ?>
                	<input type="hidden" id="success" value="<?php echo $this->session->flashdata("success"); ?>">
               <?php endif; ?>
					<div class="page-content">
						<?php if($this->show_warning) : ?>
							<?php $this->load->view('include/warning_header'); ?>
						<?php endif; ?>

								<!-- PAGE CONTENT BEGINS -->

<?php
//--- if user don't have permission to access this page then deny_page;
//_can_view_page($this->pm->can_view);
	if($this->pm->can_view == 0)
	{
		$this->load->view('deny_page');
	}
?>
