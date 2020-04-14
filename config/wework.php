<?php

return [
    // 企业的id，在管理端->"我的企业" 可以看到
    "CORP_ID"             => "xxxx",

    // "通讯录同步"应用的secret, 开启api接口同步后，可以在管理端->"通讯录同步"看到
    "CONTACT_SYNC_SECRET" => "xxxxx",

    // 客户联系”-“客户”页面。点开“API”小按钮，可以看到secret，此为外部联系人secret
    "EXTERNAL_CONTACT_SECRET" => "xxxx",

    // 某个自建应用的id及secret, 在管理端 -> 企业应用 -> 自建应用, 点进相应应用可以看到
    "APP_ID"              => 1000006,
    "APP_SECRET"          => "xxxx",

    // 打卡应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 打卡，
    // 点进去，有个"api"按钮，点开后，会看到
    "CHECKIN_APP_ID"      => 1000000,
    "CHECKIN_APP_SECRET"  => "xxxx",

    // 审批应用的 id 及secrete， 在管理端 -> 企业应用 -> 基础应用 -> 审批，
    // 点进去，有个"api"按钮，点开后，会看到
    "APPROVAL_APP_ID"     => 1000000,
    "APPROVAL_APP_SECRET" => "xxxx",
];
