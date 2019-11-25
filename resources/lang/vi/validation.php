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

    'accepted' => 'Thuộc tính này phải được chấp nhận',
    'active_url' => 'Đây không phải là một URL ',
    'after' => 'Phải là ngày sau ngày :date.',
    'after_or_equal' => 'Phải là ngày sau hoặc bằng ngày :date.',
    'alpha' => 'Thuộc tính chỉ được chứa các ký tự chữ cái',
    'alpha_dash' => ' Thuộc tính chỉ có thể chứa các chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => ' Thuộc tính chỉ có thể chứa các chữ cái và số.',
    'array' => 'Thuộc tính  phải là một mảng.',
    'before' => 'Phải là ngày trước :date.',
    'before_or_equal' => 'Phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ' Giá trị phải nằm trong khoảng :min và :max.',
        'file' => ' Kích thước phải nằm trong khoảng :min và :max kilobytes.',
        'string' => ' Kích thước phải nằm trong khoảng :min và :max ký tự.',
        'array' => ' Kích thước mảng phải nằm trong khoảng :min và :max',
    ],
    'boolean' => ' Chỉ có giá trị true hoặc false.',
    'confirmed' => 'Định dạng không khớp',
    'date' => ' Đây không phải là một ngày',
    'date_equals' => ' Phải là ngày :date.',
    'date_format' => ' Ngày không khớp với định dạng :format.',
    'different' => ' :attribute và :other phải khác nhau',
    'digits' => ' Giá trị phải là :digits chữ số',
    'digits_between' => ' :attribute phải có ít nhất :min và nhiều nhất :max chữ số.',
    'dimensions' => ' :attribute không đúng với kích thước hợp lệ',
    'distinct' => ' :attribute trường thuộc tính có giá trị trùng lặp',
    'email' => ' Đây không phải một địa chỉ email',
    'ends_with' => ' :attribute phải kết thúc bằng một trong các giá trị sau: :values',
    'exists' => ' Chọn :attribute không hợp lệ.',
    'file' => ' :attribute phải là một tệp.',
    'filled' => ' :attribute phải có giá trị.',
    'gt' => [
        'numeric' => ' Giá trị phải lớn hơn :value.',
        'file' => ' Kích thước tệp phải lớn hơn :value kilobytes.',
        'string' => ' Chuỗi phải có nhiều hơn :value ký tự.',
        'array' => ' Mảng phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ' Giá trị phải lớn hơn hoặc bẳng :value.',
        'file' => ' Kích thước tệp phải lớn hơn hoặc bẳng :value kilobytes.',
        'string' => ' Chuỗi phải có nhiều hơn hoặc bẳng :value ký tự.',
        'array' => ' Mảng phải có nhiều hơn hoặc bẳng :value phần tử',
    ],
    'image' => ' Phải là một tệp ảnh',
    'in' => ' Chọn :attribute không hợp lệ',
    'in_array' => ' :attribute không tồn tại trong :other.',
    'integer' => ' Giá trị phải là một số nguyên',
    'ip' => ' :attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ' :attribute phải là một địa chỉ IP4 hợp lệ.',
    'ipv6' => ' :attribute phải là một địa chỉ IP6 hợp lệ.',
    'json' => ' :attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => 'Giá trị phải nhỏ hơn :value.',
        'file' => ' Kích thước tệp phải nhỏ hơn :value kilobytes.',
        'string' => ' Chuỗi phải nhỏ hơn :value ký tự.',
        'array' => 'Mảng phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ' Giá trị phải nhỏ hơn hoặc bằng :value.',
        'file' => ' Kích thước tệp phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ' Chuỗi phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ' Mảng không thể có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ' Giá trị không thể lớn hơn :max.',
        'file' => ' Kích thước tệp không thể lớn hơn :max kilobytes.',
        'string' => ' Chuỗi không thể lớn hơn :max ký tự.',
        'array' => ' Mảng không thể có nhiều hơn :max phần tử.',
    ],
    'mimes' => ' :attribute phải là tệp có định dạng: :values.',
    'mimetypes' => ' :attribute phải là tệp có định dạng: :values.',
    'min' => [
        'numeric' => ' Giá trị không thể nhỏ hơn :min.',
        'file' => ' Kích thước tệp không thể nhỏ hơn :min kilobytes.',
        'string' => ' Chuỗi không thể nhỏ hơn :min ký tự.',
        'array' => ' Mảng không thể có ít hơn :min phần tử.',
    ],
    'not_in' => ' Chọn :attribute không hợp lệ.',
    'not_regex' => ' :attribute có định dạng không hợp lệ',
    'numeric' => ' Giá trị phải là một số',
    'present' => ' :attribute phải có',
    'regex' => ' :attribute có định dạng không hợp lệ',
    'required' => ' Đây là thuộc tính bắt buộc',
    'required_if' => ' Đây là thuộc tính bắt buộc khi :other là :value.',
    'required_unless' => ' Đây là thuộc tính bắt buộc',
    'required_with' => ' Đây là thuộc tính bắt buộc khi giá tị :values xuất hiện.',
    'required_with_all' => ' Đây là thuộc tính bắt buộc khi các giá trị :values xuất hiện.',
    'required_without' => ' Đây là thuộc tính bắt buộc khi :values không xuất hiện.',
    'required_without_all' => ' Đây là thuộc tính bắt buộc khi không có giá trị nào trong :values xuất hiện.',
    'same' => ' :attribute và :other must match.',
    'size' => [
        'numeric' => ' Giá trị số phải có kích thước bằng :size.',
        'file' => ' Kích thước tệp phải có kích thước bằng :size kilobytes.',
        'string' => ' Chuỗi phải có kích thước bằng :size ký tự.',
        'array' => ' Mảng phải chứa :size phần tử.',
    ],
    'starts_with' => ' :attribute phải bắt đầu bằng một trong các giá trị sau: :values',
    'string' => ' Đây phải là một chuỗi.',
    'timezone' => ' :attribute phải là múi giờ hợp lệ.',
    'unique' => ' Giá trị đã tồn tại',
    'uploaded' => ' :attribute không thể tải lên',
    'url' => ' URL có định dạng không hợp lệ',
    'uuid' => ' :attribute phải là UUID hợp lệ.',

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
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
