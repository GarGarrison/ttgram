!function(e){function t(t){for(var r,s,l=t[0],o=t[1],_=t[2],c=0,u=[];c<l.length;c++)s=l[c],i[s]&&u.push(i[s][0]),i[s]=0;for(r in o)Object.prototype.hasOwnProperty.call(o,r)&&(e[r]=o[r]);for(d&&d(t);u.length;)u.shift()();return n.push.apply(n,_||[]),a()}function a(){for(var e,t=0;t<n.length;t++){for(var a=n[t],r=!0,l=1;l<a.length;l++){var o=a[l];0!==i[o]&&(r=!1)}r&&(n.splice(t--,1),e=s(s.s=a[0]))}return e}var r={},i={4:0},n=[];function s(t){if(r[t])return r[t].exports;var a=r[t]={i:t,l:!1,exports:{}};return e[t].call(a.exports,a,a.exports,s),a.l=!0,a.exports}s.m=e,s.c=r,s.d=function(e,t,a){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},s.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(s.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)s.d(a,r,function(t){return e[t]}.bind(null,r));return a},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="/dist/";var l=window.webpackJsonp=window.webpackJsonp||[],o=l.push.bind(l);l.push=t,l=l.slice();for(var _=0;_<l.length;_++)t(l[_]);var d=o;n.push([30,0]),a()}({30:function(e,t,a){"use strict";a.r(t);var r=a(4),i=a(0),n=a.n(i),s=a(26),l=a(7),o=a(6),_=a(15),d=a(3),c=a(9),u=a(8),m=a(11),g=a.n(m),p={",":" зпт ",".":" тчк ","'":" квч ",'"':" квч ","(":" скб ",")":" скб ","!":" восклицательный знак ","?":" знак вопроса ","%":" процент ","-":" минус "};new r.a({el:"#ttgram",data:{step:1,last_step:5,lang:{language:"Russian",months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthsAbbr:["Янв","Февр","Март","Апр","Май","Июнь","Июль","Авг","Сент","Окт","Нояб","Дек"],days:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],rtl:!1,ymd:!1,yearSuffix:""},saved_receiver:"",saved_template:"",picker_copy_date:"",picker_delivery_date:"",save_myself:!1,password:"",confirm_password:"",save_receiver:!1,template_name:"",telegraf_abbr:!1,telegram_data:{s_type:"fiz",s_fio:document.getElementById("s_fio").getAttribute("value"),r_name:"",r_surname:"",s_company:document.getElementById("s_company").getAttribute("value"),r_company:"",s_phone:document.getElementById("s_phone").getAttribute("value"),r_phone:"",s_email:document.getElementById("s_email").getAttribute("value"),r_email:"",s_region:document.getElementById("s_region").getAttribute("value"),r_region:"",s_city:document.getElementById("s_city").getAttribute("value"),r_city:"",s_street:document.getElementById("s_street").getAttribute("value"),r_street:"",s_building:document.getElementById("s_building").getAttribute("value"),r_building:"",s_flat:document.getElementById("s_flat").getAttribute("value"),r_flat:"",notification:"",notification_quick:"",service_type:"telegram",payment_type:"",text:"",word_count:0,copy_date:"",copy_number:"",delivery_date:"",restante:!1,blank:""},request_number:"",showModal:!1,validate_errors:{}},mixins:[g.a],watch:{picker_copy_date:function(e){this.telegram_data.copy_date=this.process_date(e)},picker_delivery_date:function(e){this.telegram_data.delivery_date=this.process_date(e)},"telegram_data.text":function(){this.telegraf_abbr&&this.telegraf_abbr_replace()}},methods:{next:function(){this.step++},changeStep:function(e){var t=this.step,a=e.target.getAttribute("data-step");a<t&&(this.step=a)},federalCity:function(e){"sender"==e&&(this.telegram_data.s_city=this.telegram_data.s_region),"receiver"==e&&(this.telegram_data.r_city=this.telegram_data.r_region)},updateRegionFromCity:function(e,t){var a=e.name,r=e.typeShort,i=e.compute_value(a,r);"sender"==t&&(this.telegram_data.s_region=i),"receiver"==t&&(this.telegram_data.r_region=i)},processFile:function(e){var t=this,a=e.target.files[0],r=new FileReader;r.onload=function(e){t.telegram_data.text=r.result},r.readAsText(a)},chooseReceiver:function(){var e=this;n.a.get("/get_receiver_data/"+this.saved_receiver).then(function(t){var a=t.data;e.telegram_data.r_name=a.name,e.telegram_data.r_surname=a.surname,e.telegram_data.r_company=a.company,e.telegram_data.r_phone=a.phone||"",e.telegram_data.r_email=a.email,e.telegram_data.r_region=a.region,e.telegram_data.r_city=a.city,e.telegram_data.r_street=a.street,e.telegram_data.r_building=a.building,e.telegram_data.r_flat=a.flat}).catch(function(e){console.log(e)})},chooseTemplate:function(){var e=this;n.a.get("/get_template_data/"+this.saved_template).then(function(t){var a=t.data;e.telegram_data.text=a.template}).catch(function(e){console.log(e)})},telegraf_abbr_replace:function(){var e=this.telegram_data.text,t=this.telegraf_abbr;for(k in p){var a="",r=p[k];a="("==k?/\(/g:")"==k?/\)/g:"."==k?/\./g:"?"==k?/\?/g:new RegExp(k,"g"),t||(a=new RegExp(p[k],"g"),r=k),e=e.replace(a,r)}this.telegram_data.text=e.replace(/  /g," ")},validate_steps:function(e){var t=this,a=t.$data.telegram_data;1==e&&(d.default.validateRules(t,a,!0,["s_fio","notification"]),"jur"==this.telegram_data.s_type&&d.default.validateRules(t,a,!1,["s_company"]),"address"==this.telegram_data.notification&&d.default.validateRules(t,a,!1,["s_fio","notification","s_region","s_city","s_street","s_building"]),"phone"==this.telegram_data.notification&&d.default.validateRules(t,a,!1,["s_phone"]),"email"==this.telegram_data.notification&&d.default.validateRules(t,a,!1,["s_email"])),this.telegramStep&&d.default.validateRules(t,a,!0,["r_name","r_surname","r_region","r_city","r_street","r_building"]),this.copyStep&&d.default.validateRules(t,a,!0,["copy_date","copy_number","payment_type"]),4==e&&d.default.validateRules(t,a,!0,["text","payment_type"])},submit:function(){this.validate_steps(this.step),Object.keys(this.validate_errors).length||(this.telegramStep&&this.save_receiver?this.showModal=!0:1==this.step&&this.save_myself?this.showModal=!0:this.next())},submit_finally:function(){var e=this;e.validate_steps(e.step),Object.keys(e.validate_errors).length||n.a.post("/save_telegram",e.telegram_data).then(function(t){e.request_number=t.data,e.step=e.last_step}).catch(function(e){console.log(e)})},submit_receiver:function(){var e=this,t=e.$refs.reciever_form.getAttribute("action"),a={template_name:e.template_name,name:e.telegram_data.r_name,surname:e.telegram_data.r_surname,company:e.telegram_data.r_company,phone:e.telegram_data.r_phone,email:e.telegram_data.r_email,region:e.telegram_data.r_region,city:e.telegram_data.r_city,street:e.telegram_data.r_street,building:e.telegram_data.r_building,flat:e.telegram_data.r_flat};n.a.post(t,a).then(function(t){e.showModal=!1,e.next()}).catch(function(e){console.log(e)})},submit_register:function(){var e=this,t=e.$refs.register_form.getAttribute("action"),a={user_type:e.telegram_data.s_type,fio:e.telegram_data.s_fio,company:e.telegram_data.s_company,phone:e.telegram_data.s_phone,email:e.telegram_data.s_email,region:e.telegram_data.s_region,city:e.telegram_data.s_city,street:e.telegram_data.s_street,building:e.telegram_data.s_building,flat:e.telegram_data.s_flat,password:e.password,password_confirmation:e.confirm_password};n.a.post(t,a).then(function(t){e.showModal=!1,e.next()}).catch(function(t){var a=t.data.errors;if(a)for(var r=Object.keys(a),i=0;i<r.length;i++){var n=r[i];e.$set(e.validate_errors,n,a[n][0])}console.log(t)})},process_date:function(e){return e.toISOString().slice(0,10)}},computed:{telegramStep:function(){return 3==this.step&&("telegram"==this.telegram_data.service_type||"international"==this.telegram_data.service_type)},copyStep:function(){return 3==this.step&&("copy_in"==this.telegram_data.service_type||"copy_out"==this.telegram_data.service_type)}},components:{vuejsDatepicker:s.a,MaskedInput:l.a,Modal:o.a,TlgTextarea:_.a,KladrItem:c.a,KladrBlock:u.a}})}});