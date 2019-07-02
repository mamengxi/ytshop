/**
 * 省市三级联动-修改版
 */
(function($){
    var citys = Area;
    var pca = {};

    pca.city = {};
    pca.area = {};
    
    pca.init = function(province, city, area, initprovince, initcity, initarea){//jQuery选择器, 省-市-区
        //省份选择器
        if(!province || !$(province).length) return; 
        //清空省份选择器内容
        $(province).html('');
        //开始赋值
        $(province).append('<option  value="">请选择省</option>');
        //遍历赋值
        for(var i in citys){
            $(province).append('<option value= '+citys[i].provinceName+'>'+citys[i].provinceName+'</option>');
            pca.city[citys[i].provinceName] = citys[i].mallCityList;
        }
        //渲染页面
        layui.form.on('select').render();
        //检测省份是否设置
        if(initprovince) {
            $(province).find('option[value="'+initprovince+'"]').attr('selected', true);    
        }

        //城市选择器
        if(!city || !$(city).length) return;
        //渲染空数据
        pca.formRender(city,'请选择市');
        //监听事件
        layui.form.on('select(province)', function(data){
            pca.formRender(area,'请选择县/区');
            pca.cityRender(city,data.value);
        }); 

        if(initcity) {
            pca.cityRender(city,initprovince);
            $(city).find('option[value="'+initcity+'"]').attr('selected', true);
        }

        //区县选择器
        if(!area || !$(area).length) return;
        //渲染空数据
        pca.formRender(area,'请选择县/区');
        //监听事件
        layui.form.on('select(city)', function(data){
            pca.areaRender(area,data.value);
        }); 
        if(initarea) {
            pca.areaRender(area,initcity);
            $(area).find('option[value="'+initarea+'"]').attr('selected', true);
            layui.form.on('select').render();
        }
    }
    
    pca.formRender = function(obj,text){
        $(obj).html('');
        $(obj).append('<option value="">'+text+'</option>');
        layui.form.on('select').render();
    }

    pca.cityRender = function(obj,data){
        var city_select = pca.city[data];
        $(obj).html('');
        $(obj).append('<option value="">请选择市</option>');
        if(city_select){
            for(var i in city_select){
                $(obj).append('<option value= '+city_select[i].cityName+'>'+city_select[i].cityName+'</option>');
                pca.area[city_select[i].cityName] = city_select[i].mallAreaList;
            }
        }
        layui.form.on('select').render();
    }

    pca.areaRender = function(obj,data){
        var area_select = pca.area[data];
        $(obj).html('');
        $(obj).append('<option value="">请选择县/区</option>');
        if(area_select){
            for(var i in area_select){
                $(obj).append('<option value= '+area_select[i].areaName+'>'+area_select[i].areaName+'</option>');
            }
        }
        layui.form.on('select').render();
    }

    window.pca = pca;
    return pca;
})($);