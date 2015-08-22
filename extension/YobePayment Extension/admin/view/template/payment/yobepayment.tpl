      <?php echo $header; ?><?php echo $column_left; ?>
      <div id="content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="pull-right">
              <button type="submit" form="form-yobe-payment" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-yobe-payment"  class="form-horizontal">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="Enable">Enable</span></label>
                    <div class="col-sm-10">
                      <select name="yobepayment_status" id="input-status" class="form-control">
                        <?php if ($yobepayment_status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>                      
                    </div>
                  </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                  <div class="col-sm-10">
                    <select name="yobepayment_order_status_id" id="input-order-status" class="form-control">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $yobepayment_order_status_id) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="Choose Zone To Active">Geo Zone</span></label>
                    <div class="col-sm-10">
                      <select name="yobepayment_geo_zone_id" id="input-status" class="form-control">
                        <option value="0"><?php echo $text_all_zones; ?></option>
                        <?php foreach ($geo_zones as $geo_zone) { ?>
                        <?php if ($geo_zone['geo_zone_id'] == $yobepayment_geo_zone_id) { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="Enter Number Of Bank">Number Of Bank</span></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="yobepayment_number_method" value="<?php echo $yobepayment_number_method; ?>" size="5" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="Sort Order">Sort Order</span></label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="yobepayment_sort_order" value="<?php echo $yobepayment_sort_order; ?>" size="5" />
                    </div>
                  </div>
                  <div class="table-responsive">
                  <?php
                  for($i=1;$i<=$yobepayment_number_method;$i++){
                   ?>
                   <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <td class="text-left required"><?php echo $entry_name;?></td>
                      <td class="text-left required"><?php echo $entry_yobepayment;?></td>
                      <td class="text-left required"><?php echo $entry_image;?></td>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-center col-sm-2"><input type="text" name="yobepayment_name<?php echo $i;?>" value="<?php echo ${'yobepayment_name'.$i}; ?>" /></td>
                        <td class="text-left col-sm-7">
                      <?php foreach ($languages as $language) { ?>
                        <textarea name="yobepayment_<?php echo $language['language_id']; ?>_<?php echo $i; ?>" cols="90" rows="10"><?php echo isset(${'yobepayment_' . $language['language_id']. '_'.$i}) ? ${'yobepayment_' . $language['language_id']. '_' . $i} : ''; ?></textarea>
                          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /><br />
                          <?php if (isset(${'error_yobepayment_' . $language['language_id']. '_' . $i})) { ?>
                          <span class="error"><?php echo ${'error_yobepayment_' . $language['language_id']. '_' . $i}; ?></span>
                          <?php } ?>
                        <?php } ?>
                        </td>
                          <td class="text-center col-sm-4">
                            <div class="image">
                              <a href="" id="thumb-<?php echo $i; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo ${'thumb'.$i}; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                              <input type="hidden" name="yobepayment_image<?php echo $i; ?>" value="<?php echo ${'yobepayment_image'.$i}; ?>" id="input-image<?php echo $i; ?>" />
                          </div>
                          <?php if ($error_image) { ?>
                          <span class="error"><?php echo $error_image; ?></span>
                          <?php } ?></td>
                        </tr>
                      </tbody>
                    </table>
                    <?php } ?>
                  </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php echo $footer; ?>