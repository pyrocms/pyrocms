<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"             => ":attribute , يجب أن يتم قبوله.",
    "active_url"           => ":attribute عنوان URL غيرصالح.",
    "after"                => ":attribute يجب أن يكون التاريخ بعد :date.",
    "alpha"                => ":attribute , يجب أن يحوي على حروف فقط.",
    "alpha_dash"           => ":attribute ,ربما يجب أن يحوي حروف وأرقام وشرطات فقط.",
    "alpha_num"            => ":attribute ,ربما يجب أن يحوي حروف وأرقام  فقط.",
    "array"                => ":attribute يجب أن يكون مصفوفة.",
    "before"               => ":attribute يجب أن يكون التاريخ قبل :date.",
    "between"              => [
      "numeric" => " :attribute يجب أن يكون بين :min و :max.",
      "file"    => " :attribute يجب أن يكون بين :min and :max كيلوبايب.",
      "string"  => " :attribute يجب أن يكون بين :min and :max حروف.",
      "array"   => " :attribute يجب أن يكون لديه من :min إلى :max عناصر.",
    ],
    "boolean"              => ":attribute الحقل يجب أن يكون true أو false",
    "confirmed"            => ":attribute التأكيد لا يتطابق.",
    "date"                 => ":attribute تاريخ غير صالح.",
    "date_format"          => ":attribute لا يتفق مع الصيغة :format.",
    "different"            => ":attribute و :other يجب أن يكونا مختلفان.",
    "digits"               => ":attribute يجب أن يكون :digits رقم.",
    "digits_between"       => ":attribute يجب أن يكون بين :min و :max رقم.",
    "email"                => ":attribute يجب أن يكون عنوان بريد صالح.",
    "filled"               => ":attribute هذا الحقل مطلوب.",
    "exists"               => "الذي تم اختياره :attribute غير صالح.",
    "image"                => ":attribute يجب أن يكون صورة.",
    "in"                   => ":attribute الذي تم اختياره غير صالح.",
    "integer"              => ":attribute يجب أن يكون رقم.",
    "ip"                   => ":attribute يجب أن يكون عنوان IP صالح.",
    "max"                  => [
      "numeric" => ":attribute يجب أن لا يكون أكبر من :max.",
      "file"    => ":attribute يجب أن لا يكون أكبر من :max كيلوبايت.",
      "string"  => ":attribute يجب أن لا يكون أكبر من :max حرف.",
      "array"   => ":attribute يجب أن لا يكون لديها أكثر من :max عناصر.",
  ],
  "mimes"                => ":attribute يجب أن يكون ملف من نوع: :values.",
  "min"                  => [
      "numeric" => ":attribute يجب أن يكون على الأقل :min.",
      "file"    => ":attribute يجب أن يكون على الأقل :min كيلوبايت.",
      "string"  => ":attribute يجب أن يكون على الأقل :min حرف.",
      "array"   => ":attribute يجب أن يكون لديها على الأقل :min عناصر.",
  ],
  "not_in"               => ":attribute المختار غير صالح.",
  "numeric"              => ":attribute يجب أن يكون رقم.",
  "regex"                => ":attribute الصيغة غير صالحة.",
  "required"             => ":attribute الحقل مطلوب.",
  "required_if"          => ":attribute الحقل مطلوب عندما :other يكون :value.",
  "required_with"        => ":attribute الحقل مطلوب عندما :values يكون موجود.",
  "required_with_all"    => ":attribute الحقل مطلوب عندما :values يكون موجود.",
  "required_without"     => ":attribute الحقل مطلوب عندما :values غير موجود.",
  "required_without_all" => ":attribute الحقل مطلوب عندما ولا أي :values تكون موجودة.",
  "same"                 => ":attribute و :other يجب ان بتطابقا.",
  "size"                 => [
      "numeric" => ":attribute يجب أن يكون :size.",
      "file"    => ":attribute يجب أن يكون :size كيلوبايت.",
      "string"  => ":attribute يجب أن يكون :size حرف.",
      "array"   => ":attribute يجب أن يحوي :size عناصر.",
  ],
  "غير صالح"              => ":attribute is غير صالح.",
  "unique"               => ":attribute تم أخذه مسبقاً.",
  "unique_trash"         => ":attribute ربما تم أخذخ مسبقا بواسطة مدخل مهمل.",
  "url"                  => ":attribute صيغة غير صالحة.",
  "timezone"             => ":attribute يجب أن يكون منطقة زمنية صالحة.",
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة-مخصصة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
