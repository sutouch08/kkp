<div class="row">
	<div class="col-sm-12 col-xs-12 padding-5" >
		<div class="tabbable tabs-left" style="display:flex;">
			<ul class="nav nav-tabs" id="myTab3" style="min-width: 100px; min-height:300px;">
				<li class="active">
					<a data-toggle="tab" href="#top" aria-expanded="true" onclick="getOrderTabs(0)">
						HOME
					</a>
				</li>

		<?php $tabs = $this->product_tab_model->getChild(0); ?>
		<?php  if(!empty($tabs)) : ?>
			<?php foreach($tabs as $rs) : ?>
				<li class="">
					<a data-toggle="tab" href="#cat-<?php echo $rs->id; ?>" aria-expanded="false" onclick="getItemTabs(<?php echo $rs->id; ?>)"><?php echo $rs->name; ?></a>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
			</ul>

			<div class="tab-content width-100 margin-bottom-10" style="height:300px; overflow-y:scroll;">
				<div id="top" class="tab-pane active">
		<?php	$qs = $this->product_tab_model->get_item_in_tab(0); ?>
		<?php if(!empty($qs)) : ?>
			<?php foreach($qs as $rs) : ?>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="padding:5px;">
					<div class="border-1" style="padding:10px;">
						<div class="image">
							<a href="javascript:void(0)" onclick="getOrderItemGrid('<?php echo $rs->code; ?>')">
								<img class="img-responsive" src="<?php echo get_product_image($rs->code, 'default'); ?>" />
							</a>
						</div>
						<div class="description" style="overflow: hidden; line-height: 18px; height:42px; font-size:16px; font-weight:400;">
							ssssssssssssssssss<?php echo $rs->name; ?>
						</div>
						<div class="description" style="height:20px; font-size:10px;">
							รหัสสินค้า &nbsp;&nbsp;<?php echo $rs->code; ?>
						</div>
						<div class="price red bold" style="font-size:18px;">
							<?php echo number($rs->price, 2); ?> ฿
						</div>
						<div class="width-50">
							<div class="input-group">
								<span class="input-group-btn"><button type="button" class="btn btn-white padding-10"><i class="fa fa-minus"></i></button></span>
								<input type="number" class="form-control text-center" style="font-size:14px;" value="1" id="<?php echo $rs->code; ?>" />
								<span class="input-group-btn"><button type="button" class="btn btn-white padding-10"><i class="fa fa-plus"></i></button></span>
							</div>
						</div>
						<div class="width-50">

						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>

				</div>
				<?php if(!empty($tabs)) : ?>
					<?php foreach($tabs as $rs) : ?>
						<div id="cat-<?php echo $rs->id; ?>" class="tab-pane"></div>
				<?php endforeach; ?>
			<?php endif; ?>

			</div>
		</div>

		<!-- /section:elements.tab.position -->
	</div>										<!-- #section:elements.tab.position -->


</div>
