<?php

    global $user;

    if ($user->uid) {
        $u = user_load($user->uid);
    }

   // var_dump($u->roles);
    $isMember = usgbc_store_is_member($user);

    $items = uc_cart_get_contents();
    
    $context = array(
    		'revision' => 'themed-original',
    		'type' => 'amount',
    );

    $hasPublication = false;
    foreach ($items as $product) {
        $node = node_load($product->nid);

        if ($node->type == 'resource') {
            $hasPublication = true;
        } else {
            uc_cart_remove_item($item->nid);
        }
    }


    $items = uc_cart_get_contents(null, 'rebuild');
    $isShippable = uc_cart_is_shippable();

    drupal_add_js('var isShippable = '.$isShippable .';', 'inline');


    //Remove Form Element wrapper
    foreach ($form as $k => $v) {
        if (!is_array($v)) continue;
        if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
    }

    $form['items'][$item_id]['title']['#wrapper'] = false;
    $form['items'][$item_id]['price']['#wrapper'] = false;
    $form['items'][$item_id]['qty']['#wrapper'] = false;
    $form['items'][$item_id]['total']['#wrapper'] = false;
    $form['items'][$item_id]['remove']['#wrapper'] = false;

    //Set var for custom display of error messages
    global $form_has_errors;
    $form_id = $form['form_id']['#value'];
    $message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));
?>


<div id="mainCol">
    <?php
    //Pre-render form element for inline error message
    $render_form['country'] = drupal_render($form['country']);
    $render_form['zip'] = drupal_render($form['zip']);
    $render_form['shippingmethod'] = drupal_render($form['shippingmethod']);
    $render_form['discountcode'] = drupal_render($form['discountcode']);

    if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
?>
<div>
    <p class="notification negative"><?php echo $message; ?></p>
</div>
<?php endif; ?>

    <table id="cart" cellspacing="0">
        <thead>
        <tr>
            <td colspan="2">
                <table cellspacing="0">
                    <thead>
                    <tr>
                        <th colspan="2" class="col-thumb">Item / Description</th>
                        <th scope="col" class="col-unit">Unit</th>
                        <th scope="col" class="col-qty">Qty</th>
                        <th scope="col" class="col-price">Price</th>
                    </tr>
                    </thead>
                </table>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php
            $item_id = 0;
            foreach ($items as $product):
                ?>
            <tr id="cart_item_<?php print $product->nid;?>">
                <td class="col-thumb">

                    <img alt="" src="<?php print file_create_url(node_load($product->nid)->field_res_profileimage[0]['filepath']);?>" style="width:48px;">

                    <?php //print uc_product_get_picture($product->nid,'cart');?>
                    <input type="hidden" class="SKU" value="<?php print $product->model;?>"></input>
                </td>
                <td class="col-item">
                    <table cellspacing="0">
                        <tbody>
                        <tr class="item">
                            <td class="col-name">
                                <div><?php
                                    print drupal_render($form['items'][$item_id]['title']);
                                    ?></div>
                                <h3>
                                    <a href="<?php print $nodeurl = url('node/' . $product->nid);?>">
                                        <?php print $product->title; ?>
                                    </a></h3></td>

                            <td class="col-unit">
                                <?php print drupal_render($form['items'][$item_id]['price']);?>
                            </td>
                            <td class="col-qty">
                                <?php print drupal_render($form['items'][$item_id]['qty']);?>
                            </td>
                            <td class="col-price">
                                <?php print drupal_render($form['items'][$item_id]['total']);?>
                            </td>
                        </tr>
                        <tr class="details">
                            <td colspan="3">
                                <?php
                                if ($product->data['attributes']) {
                                    $i = 0;
                                    foreach ($product->data['attributes'] as $aid => $oid) {
                                        $option = uc_attribute_option_load($oid);
                                        $attribute = uc_attribute_load($aid);
                                        if ($i > 0) {
                                            print '<br>';
                                        }
                                        print '<strong>' . $attribute->name . ':</strong> ' . $option->name;
                                        $i += 1;
                                    }
                                }
                                ?>
                            </td>
                            <td class="remove">
                                <!--
                               <a href="">Remove item</a>
                                -->
                                <?php print drupal_render($form['items'][$item_id]['remove']);?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

                <?php
                $item_id++;
            endforeach;
        ?>


        </tbody>


        <tfoot>
        <?php if (count($items) == 0): ?>
        <tr>
            <td colspan="2">
                <div class="empty-cart"><p>Your cart is empty.</p>
                </div>
            </td>
        </tr>
            <?php else: ?>
        <tr>
            <td colspan="2">
                <div class="extra-costs">

                    <dl class="zip" <?php if(!$isShippable): ?>style="display:none;" <?php endif;?>>
                        <dt>Ship to</dt>
                        <dd>
                            <div class="left">
                                <?php print $render_form['country'];?>
                            </div>
                            <?php print $render_form['zip'];?>
                        </dd>
                    </dl>

                    <dl class="shipping-method"  <?php if(!$isShippable): ?>style="display:none;" <?php endif;?> >
                        <dt>Shipping method</dt>
                        <dd>
                          <div class="left">
                            <?php print $render_form['shippingmethod'];?>
                          </div>
                        </dd>
                    </dl>

                    <dl class="promo">
                        <dt>Promo code</dt>
                        <dd><?php print $render_form['discountcode'];?>
                            <span class="promo-on" id="discount-desc">
                                            <?php print drupal_render($form['discountdesc']);?>
                                <!--
                                <small><a class="change-promo" href="">change</a></small>
                                -->
                                        </span></dd>
                    </dl>
                </div>

                <div class="costs">
                    <dl class="subtotal">
                        <dt>Subtotal</dt>
                        <dd><?php print drupal_render($form['subtotal']);?></dd>
                    </dl>

                    <dl class="shipping">
                        <dt>Shipping & Handling</dt>
                        <dd>
                            <?php
                            if ((float)$form['shippingamount']['#value'] > 0):
                                print uc_currency_format(drupal_render($form['shippingamount']));
                            else:
                                print '--';
                            endif;?>
                        </dd>
                    </dl>
                    <?php if ((float)$form['discountamount']['#value'] > 0): ?>

                    <dl class="promo">
                        <dt>Promo <span class="promo-code"></span></dt>
                        <dd>-<?php print uc_currency_format(drupal_render($form['discountamount']));?>
                        </dd>
                    </dl>
                    <?php endif;?>
                    
                    <dl class="hidden">
                        <dt>Tax</dt>
                        <dd>
						<?php if ((float)$form['tax']['#value'] > 0)
							{
								print uc_price(drupal_render($form['tax']));}
							else 
							{	print '--';}
						?>
                        </dd>
                    </dl>
                    
                    
                </div>
            </td>
        </tr>
            <?php endif;?>
        </tfoot>

    </table>

    <div class="button-group left">

        <?php if (count($items) > 0):
        print drupal_render($form['update']);
        print drupal_render($form['checkout']);
    endif;?>

        <a class="button-note" href="/store/">Continue shopping</a>
    </div>
    <?php if (count($items) > 0): ?>

    <dl class="cart-total">
        <dt>Total</dt>
        <dd><?php print uc_currency_format(drupal_render($form['total']));?></dd>
    </dl>
    <?php endif;?>
</div>


<div id="sideCol">
    <?php if (count($items) > 0): ?>
    <div id="attention-feed">
        <ul class="linelist">
            <?php if ($isMember): ?>
            <li class="alert-positive first">
                            <span class="alert-msg">You save <?php print drupal_render($form['totalmemberdiscount']);?>
                                with your USGBC membership! <br>
                            <!--<span class="small">Already a member? <a href="/themes/usgbc/lib/inc/modals/acct-sign-in.php" class="jqm-form-trigger">Sign in</a></span></span>-->
                        </span></li>
            <?php  elseif (user_is_logged_in()):

            ?>
            <li class="alert-neutral first">
                        <span class="alert-msg">You could save <?php print drupal_render($form['totalmemberdiscount']);?>
                            with a USGBC membership. <br>
						<span class="small">Not a member? <a href="/community/members">Join</a></span></span>
            </li>
            <?php  else: ?>
            <li class="alert-neutral first">
                            <span class="alert-msg">You could save <?php print drupal_render($form['totalmemberdiscount']);?>
                                with a USGBC membership. <br>
                            <span class="small">Already a member? <a href="/user/login?destination=store/cart" class="jqm-form-trigger">Sign in</a></span></span>
            </li>
            <?php endif;?>
            <?php if ($hasPublication): ?>
            <li class="alert-neutral"><span class="alert-msg">Please note that publications cannot be returned or exchanged.</span>
            </li>
            <?php endif;?>
        </ul>
    </div>
    <?php endif;?>
</div>

<div class="hidden">
    <?php print drupal_render($form); ?>
</div>
