<?php

namespace cnb\admin\domain;

use cnb\admin\models\CnbAgencyPlan;
use cnb\utils\CnbUtils;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class CnbProAccountBlocks {

    /**
     * @var string eur or usd
     */
    private $active_currency;

    public function __construct( $active_currency ) {
        $this->active_currency = $active_currency;
    }

    public function render_pro_account_block() {
        ?>
        <div id="domain_bundle" class="cnb-welcome-blocks">
            <h1><strong>Agency Account</strong></h1>
            <h3>Domain bundle at a discounted price for web agencies and power users that need buttons on a large number of websites.</h3>
            <h2><span class="dashicons dashicons-yes"></span> Includes <u>20 PRO websites</u></h2>
            <br>
            <?php
            $this->render_pro_account_links();
            ?>
        </div>
        <?php
    }
    /**
     *
     * @return void
     */
    public function render_pro_account_links() {
        /** @var CnbAgencyPlan[] $cnb_agency_plans */
        global $cnb_agency_plans;

	    $cnb_utils = new CnbUtils();

        $agency_20_monthly_plans = array_filter($cnb_agency_plans, function ($plan) {
            return $plan->seats === 20 && $plan->interval === 'monthly';
        });
        $agency_20_monthly_plan = array_shift($agency_20_monthly_plans);

	    $agency_20_yearly_plans = array_filter($cnb_agency_plans, function ($plan) {
		    return $plan->seats === 20 && $plan->interval === 'yearly';
	    });
	    $agency_20_yearly_plan = array_shift($agency_20_yearly_plans);

	    ?>

        <?php if ( ! $this->active_currency ) { ?>
            <div class="cnb-currency-toggle">
                <span class="cnb_currency_active cnb_currency_active_eur" style="font-weight:bold">EUR</span>
                <input id="cnb-currency-toggle-proAccount"
                        class="cnb-currency-toggle-cb cnb_toggle_checkbox" name="currency" type="checkbox"
                        value="usd"/>
                <label for="cnb-currency-toggle-proAccount" class="cnb_toggle_label">Toggle</label>
                <span style="display: inline-block; margin-left: 4px;"
                        class="cnb_currency_active cnb_currency_active_usd">USD</span>
            </div>
        <?php } ?>

        <div class="cnb-price-plans">
            <div class="currency-box currency-box-eur cnb-flexbox" style="<?php if ( $this->active_currency === 'usd' ) {
                echo 'display:none';
            } ?>">

                <div class="cnb-pricebox cnb-currency-box currency-box-active">
                    <h3 class="cnb-price-eur">Agency Annual</h3>

                    <div class="plan-amount"><span class="currency">&euro;</span><span
                                class="euros">499</span><span class="timeframe">/year</span>
                    </div>
                    <div class="billingprice">
                        VAT may apply
                    </div>

                    <a class="button button-primary"
                        onclick="cnb_get_agency_checkout('<?php echo esc_js( $agency_20_yearly_plan->id ) ?>', 'eur')"
                        href="#"
                    >Purchase</a>
                </div>
                <div class="cnb-pricebox cnb-currency-box currency-box-active">
                    <h3 class="cnb-price-usd">Agency Monthly</h3>

                    <div class="plan-amount"><span class="currency">&euro;</span><span
                                class="euros">49</span><span
                                class="cents">.90</span><span class="timeframe">/month</span>
                    </div>
                    <div class="billingprice">
                        VAT may apply
                    </div>

                    <a class="button button-primary"
                        onclick="cnb_get_agency_checkout('<?php echo esc_js( $agency_20_monthly_plan->id ) ?>', 'eur')"
                        href="#"
                    >Purchase</a>
                </div>
            </div>
            <div class="currency-box currency-box-usd cnb-flexbox"
                style="<?php if ( $this->active_currency !== 'usd' ) { ?>display:none<?php } ?>">

                <div class="cnb-pricebox cnb-currency-box currency-box-active">
                    <h3 class="cnb-price-eur">Agency Annual</h3>

                    <div class="plan-amount"><span class="currency">$</span><span
                                class="euros">499</span><span class="timeframe">/month</span>
                    </div>
                    <div class="billingprice">
                        VAT may apply
                    </div>

                    <a class="button button-primary"
                        onclick="cnb_get_agency_checkout('<?php echo esc_js( $agency_20_yearly_plan->id ) ?>', 'usd')"
                        href="#"
                    >Purchase</a>
                </div>
                <div class="cnb-pricebox cnb-currency-box currency-box-active">
                    <h3 class="cnb-price-usd">Agency Monthly</h3>

                    <div class="plan-amount"><span class="currency">$</span><span
                                class="euros">49</span><span
                                class="cents">.90</span><span class="timeframe">/month</span>
                    </div>
                    <div class="billingprice">
                        VAT may apply
                    </div>

                    <a class="button button-primary"
                        onclick="cnb_get_agency_checkout('<?php echo esc_js( $agency_20_monthly_plan->id ) ?>', 'usd')"
                        href="#"
                    >Purchase</a>
                </div>

            </div>
        </div>
        <p class="billingprice">
            An agency account holds up to 20 domains (included in price). <br>The PRO Account subscription enables PRO features
            on every domain in the account.<br><a href="<?php echo esc_url( $cnb_utils->get_support_url( 'contact/contact-sales/', 'upgrade-page', 'bigger-bundle' ) ) ?>" target="_blank">Contact sales</a> if you need a bigger bundle.
        </p>
        <?php
    }
}
