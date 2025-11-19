<?php

return array(
    'hooks'    => array(
        array(
            'event'    => 'beforeAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\DisableNote@removeNote',
            'priority' => 100,
        ),
        array(
            'event'    => 'beforeHttpRequest',
            'callback' => 'Extension\LimelightUtilPack\DisableNote@encryptNote',
            'priority' => 100,
        ),
        array(
            'event'    => 'pageLoad',
            'callback' => "Extension\\LimelightUtilPack\\ExtraSources@addParams",
            'priority' => 100,
        ),
        array(
            'event'    => 'afterCrmPayloadReady',
            'callback' => 'Extension\LimelightUtilPack\ExtraSources@addExtraParams',
            'priority' => 100,
        ),
        array(
            'event'    => 'afterCrmPayloadReady',
            'callback' => 'Extension\LimelightUtilPack\ExtraSources@updateCampaign',
            'priority' => 100,
        ),
        array(
            'event'    => 'beforeAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\DisableNote@removeOfferUrlFromNote',
            'priority' => 100,
        ), array(
            'event' => 'afterAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\KountCampaignSwitch@processScreeningOrder',
            'priority' => 100,
        ),
        array(
            'event' => 'beforeSplitOrderCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\KountCampaignSwitch@switchSplitCampign',
            'priority' => 100,
        ), array(
            'event' => 'beforeAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\KountCampaignSwitch@processScreeningUpsell',
            'priority' => 100,
        ),
        array(
            'event' => 'afterAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\TransactionSelect@switchCampaign',
            'priority' => 100,
        ),
        array(
            'event' => 'beforeAnyCrmRequest',
            'callback' => 'Extension\LimelightUtilPack\TransactionSelect@switchUpsellCampaign',
            'priority' => 100,
        ),
    ),
    'routes' => array(
    ),
    'settings' => array(
        array(
            'label' => 'Remove Limelight note from payload',
            'key'   => 'remove_note',
            'type'  => 'boolean',
            'value' => false,
        ),
        array(
            "label"    => "Extra Source Keys",
            "key"      => "extra_source_keys",
            "type"     => "string",
            "hint"     => "Extra paramas name in csv format (e. g: C6,C7)",
            "value"    => "",
            "optional" => true,
        ),
        array(
            'label' => 'Activate Membership Service',
            'key'   => 'membership_service',
            'type'  => 'boolean',
            'value' => false,
        ),
        array(
            'label' => 'Encrypt Limelight note from payload',
            'key'   => 'encrypt_note',
            'type'  => 'boolean',
            'value' => false,
        ),
        array(
            'label' => 'Enable campaign override',
            'key'   => 'enable_campaign_override',
            'type'  => 'boolean',
            'value' => false,
        ),
        array(
            'label' => 'Remove only offer URL from note',
            'key'   => 'remove_offer_url_from_note',
            'type'  => 'boolean',
            'value' => false,
        ), array(
            'label' => 'Enable screening based campaign switching',
            'key' => 'enable_screeningbased_campaign_switch',
            'type' => 'boolean',
            'value' => false,
            "flex" => 100
        ),
        array(
            'key' => 'screening_based_main_campaigns',
            'type' => 'string',
            'textarea' => true,
            'label' => 'Campaign id',
            'value' => '',
            'hint' => 'Add StepId|CampaignId in new line (use codebase campaignid)',
            "optional" => true
        ), 
        array(
            'key' => 'screening_based_split_campaigns',
            'type' => 'string',
            'textarea' => true,
            'label' => 'Split campaign id',
            'value' => '',
            'hint' => 'Add StepId|SplitCampaignId in new line (use codebase campaignid)',
            "optional" => true
        ),
        array(
            'label' => 'Enable Campaign Routing For Transaction Select',
            'key' => 'enable_transaction_select',
            'type' => 'boolean',
            'value' => false,
            "flex" => 100
        ),
        array(
            'label' => 'Routing Campaigns',
            'type' => 'string',
            'key' => 'routing_campaigns',
            'textarea' => true,
            'value' => '',
            'hint' => 'Add StepId|campaignId in new line (use codebase campaignid)',
            "optional" => true
        ),
        array(
            'label' => 'Transaction Select Reason',
            'type' => 'string',
            'key' => 'reason',
            'textarea' => true,
            'hint' => 'For Eg - Failed Screening',
            "optional" => true
        ),
        array(
            'label' => 'Enable Pixel Fire For Transaction Select',
            'key' => 'enable_pixel_fire',
            'type' => 'boolean',
            'value' => false,
        ),
    ),
);
