<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-layout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-layout" class="form-horizontal">
		  <table class="table table-striped table-bordered table-hover">
           <tr>
              <td class="text-left">
              <?php foreach($languages as $language){ ?><div class="input-group required"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
              <input type="text" name="yobeshipping_group_shipping[<?php echo $language['language_id']; ?>][shipping_name]" value="<?php echo $yobeshipping_group_shipping[ $language['language_id']]['shipping_name'];?>" placeholder="<?php echo $entry_shipping_title; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
                    <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
               <?php } ?>
              <?php } ?></td>
              <td colspan="4"><select name="yobeshipping_status" id="input-status" class="form-control">
              <?php if ($yobeshipping_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
             <td class="text-right"><input type="text" name="yobeshipping_sort_order" value="<?php echo $yobeshipping_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
          </tr>	
          </table>
          <table id="shiping" class="table table-striped table-bordered table-hover">
          	<thead>
              <td class="required"><?php echo $entry_name;?></td>
              <td><?php echo $entry_cost;?></td>
              <td><?php echo $entry_tax_class;?></td>
              <td><?php echo $entry_geo_zone;?></td>
            </thead>
            <tbody>
              <?php $shipping_row = 0; ?>
              <?php if(!empty($multiple_shippings['yobeshipping'])){ ?>
                <?php foreach($multiple_shippings['yobeshipping'] as $multiple_shipping){ ?>
                <tr id="shipping-row<?php echo $shipping_row; ?>">
                  <td class="text-left"><?php foreach($languages as $language){ ?><div class="input-group required"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="yobeshipping[<?php echo $shipping_row; ?>][shipping_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo $multiple_shipping['shipping_description'][$language['language_id']]['name']; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_shipping_option[$shipping_row][$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_shipping_option[$shipping_row][$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?>
                  </td>
                  <td class="text-right"><input type="text" name="yobeshipping[<?php echo $shipping_row; ?>][cost]" value="<?php echo $multiple_shipping['cost']; ?>" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>
                  <td class="text-right"><select name="yobeshipping[<?php echo $shipping_row; ?>][yobeshipping_tax_class_id]" id="input-tax-class" class="form-control">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $multiple_shipping['yobeshipping_tax_class_id']) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
                  <td class="text-right"><select name="yobeshipping[<?php echo $shipping_row; ?>][yobeshipping_geo_zone_id]" id="input-geo-zone" class="form-control">
                  <option value="0"><?php echo $text_all_zones; ?></option>
                  <?php foreach ($geo_zones as $geo_zone) { ?>
                  <?php if ($geo_zone['geo_zone_id'] == $multiple_shipping['yobeshipping_geo_zone_id']) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
                  <td class="text-left"><button type="button" onclick="$('#shipping-row<?php echo $shipping_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
                <?php $shipping_row++; ?>
               <?php } ?>
             <?php } ?>
           </tbody>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td class="text-left"><button type="button" onclick="addShipping();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript"><!--
var shipping_row = <?php echo $shipping_row; ?>;

function addShipping() {
	html  = '<tr id="shipping-row' + shipping_row + '">';
	html += '<td class="text-left">';
	<?php foreach($languages as $language){ ?>
	html += '<div class="input-group required"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>';
	html += '  <input type="text" name="yobeshipping[' + shipping_row + '][shipping_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_name; ?>" class="form-control" /></div>';
	<?php } ?>
	html += '</td>';
	html += '  <td class="text-left"><input type="text" name="yobeshipping[' + shipping_row + '][cost]" value="" placeholder="<?php echo $entry_cost; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><select name="yobeshipping[' + shipping_row + '][yobeshipping_tax_class_id]" id="input-tax-class" class="form-control">';
    html += '  <option value="0"><?php echo $text_none; ?></option>';
    <?php foreach ($tax_classes as $tax_class) { ?>
    html += '  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>';
    <?php } ?>
    html += '  </select>';
	html += '  </td>';
	html += '  <td class="text-left"><select name="yobeshipping[' + shipping_row + '][yobeshipping_geo_zone_id]" id="input-geo-zone" class="form-control">';
    html += '  <option value="0"><?php echo $text_none; ?></option>';
    <?php foreach ($geo_zones as $geo_zone) { ?>
    html += '  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>';
    <?php } ?>
    html += '  </select>';
	html += '  </td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#shipping-row' + shipping_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#shiping tbody').append(html);
	
	shipping_row++;
}
//--></script></div>
<?php echo $footer; ?>