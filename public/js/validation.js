var Validator = {
        validator: {
            "text": {
                "rgxp": /^[a-zA-Z0-9а-яА-Я, .!?]{1,}$/,
                "text": "Сообщение не должно быть пустым и может содержать только русские и английские буквы, цифры, а также пробел и знаки ,.!?"
            },
            "fio": {
                "rgxp": /^[a-zA-Zа-яА-Я -]{1,150}$/, // фамилия имя фио
                "text": "Должно содержать только русские и английские буквы и иметь длинну не более 150"
            },
            "company": {
                "rgxp": /^[a-zA-Zа-яА-Я0-9 -]{1,150}$/, // компания
                "text": "Должно содержать только русские и английские буквы, цифры и иметь длинну не более 150"
            },
            "ru": {
                "rgxp": /^[а-яА-Я-0-9 .]{1,100}$/, // регион город улица
                "text": "Должно содержать только русские буквы, цифры и иметь длинну не более 150"
            },
            "building": {
                "rgxp": /^[а-яА-Я0-9 ,./_]{1,20}$/, // дом
                "text": "Должно содержать только русские буквы, цифры, знаки .,/_ и иметь длинну не более 20"
            },
            "flat": {
                "rgxp": /^[0-9]{0,10}$/, // квартира
                "text": "Должно содержать только цифры, русские буквы и иметь длинну не более 10"
            },
            "phone": {
                "rgxp": /^[0-9() +-]{1,17}$/, // телефон
                "text": "Телефон не соответствует формату"
            },
            "email": {
                "rgxp": /^[a-zA-Z0-9._-]{1,}@[a-zA-Z0-9_-]{1,}\.[a-z]{1,}$/, // почта
                "text": "Почта не соответствует формату"
            },
            "passwd": {
                "rgxp": /^.{1,100}$/, // пароль
                "text": "Не может быть пустым"
            },
            "number": {
                "rgxp": /^.{1,100}$/, // кассовый номер
                "text": "Не может быть пустым или быть длинее 100 символов"
            },
            "date": {
                "rgxp": /.{1,}/, // дата
                "text": "Не должно быть пустым"
            },
            "notification": {
                "rgxp": /.{1,}/, // select
                "text": "Выберите способ уведомления"
            },
            "payment": {
                "rgxp": /.{1,}/, // select
                "text": "Выберите способ оплаты"
            }
        },
        inputTypes: {
            s_fio: "fio",
            name: "fio",
            surname: "fio",
            r_name: "fio",
            r_surname: "fio",
            company: "company",
            s_company: "company",
            r_company: "company",
            phone: "phone",
            s_phone: "phone",
            r_phone: "phone",
            email: "email",
            s_email: "email",
            r_email: "email",
            region: "ru",
            s_region: "ru",
            r_region: "ru",
            city: "ru",
            s_city: "ru",
            r_city: "ru",
            street: "ru",
            s_street: "ru",
            r_street: "ru",
            building: "building",
            s_building: "building",
            r_building: "building",
            flat: "flat",
            s_flat: "flat",
            r_flat: "flat",
            notification: "notification",
            text: "text",
            template: "text",
            template_name: "company",
            copy_date: "date",
            copy_number: "number",
            payment_type: "payment"
        },
        validateRules: function(vm, data_arr, refresh_errors, validation_arr) {
            if (refresh_errors) vm.validate_errors = {}
            for (var i = 0; i < validation_arr.length; i++) {
                var field = validation_arr[i];
                var field_data = data_arr[field];
                var reg_type = this.inputTypes[field];
                var rule = this.validator[reg_type];
                if (! rule['rgxp'].test(field_data)) vm.$set(vm.validate_errors, field, rule['text'])
            }
            if (Object.keys(vm.validate_errors).length) return false;
            else return true;
        }
}
