var validator = {
    "regtext": {
        "rgxp": /^[a-zA-Z0-9а-яА-Я, .!?]{1,}$/,
        "text": "Сообщение не должно быть пустым и может содержать только русские и английские буквы, а также пробел и знаки ,.!?"
    },
    "regfio": {
        "rgxp": /^[a-zA-Zа-яА-Я -]{1,150}$/, // фамилия имя фио
        "text": "должно содержать только русские и английские буквы и иметь длинну не более 150"
    },
    "regcompany": {
        "rgxp": /^[a-zA-Zа-яА-Я0-9 -]{1,150}$/, // компания
        "text": "должно содержать только русские и английские буквы, цифры и иметь длинну не более 150"
    },
    "regru": {
        "rgxp": /^[а-яА-Я-0-9 .]{1,100}$/, // регион город улица
        "text": "должно содержать только русские буквы, цифры и иметь длинну не более 150"
    },
    "regbuilding": {
        "rgxp": /^[а-яА-Я0-9 ,./_]{1,20}$/, // дом
        "text": "должно содержать только русские буквы, цифры, знаки .,/_ и иметь длинну не более 20"
    },
    "regflat": {
        "rgxp": /^[0-9]{0,10}$/, // квартира
        "text": "должно содержать только цифры, русские буквы и иметь длинну не более 10"
    },
    "regphone": {
        "rgxp": /^[0-9() +-]{1,17}$/, // телефон
        "text": "телефон не соответствует формату"
    },
    "regemail": {
        "rgxp": /^[a-zA-Z0-9._-]{1,}@[a-zA-Z0-9_-]{1,}\.[a-z]{1,}$/, // почта
        "text": "почта не соответствует формату"
    },
    "regpasswd": {
        "rgxp": /^.{1,100}$/, // пароль
        "text": "не может быть пустым"
    },
    "regnumber": {
        "rgxp": /^.{1,100}$/, // кассовый номер
        "text": "не может быть пустым или быть длинее 100 символов"
    },
    "regdate": {
        "rgxp": /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/, // дата
        "text": "должно иметь формат ГГГГ-ММ-ДД"
    },
    "regnotification": {
        "rgxp": /.{1,}/, // select
        "text": "выберите способ уведомления"
    }
}

var input_types = {
    s_fio: "regfio",
    name: "regfio",
    surname: "regfio",
    r_name: "regfio",
    r_surname: "regfio",
    company: "regcompany",
    s_company: "regcompany",
    r_company: "regcompany",
    phone: "regphone",
    s_phone: "regphone",
    r_phone: "regphone",
    email: "regemail",
    s_email: "regemail",
    r_email: "regemail",
    region: "regru",
    s_region: "regru",
    r_region: "regru",
    city: "regru",
    s_city: "regru",
    r_city: "regru",
    street: "regru",
    s_street: "regru",
    r_street: "regru",
    building: "regbuilding",
    s_building: "regbuilding",
    r_building: "regbuilding",
    flat: "regflat",
    s_flat: "regflat",
    r_flat: "regflat",
    notification: "regnotification",
    text: "regtext",
    copy_date: "regdate",
    copy_number: "regnumber"
}
