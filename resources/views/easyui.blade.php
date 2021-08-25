<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-easyui/themes/default/easyui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-easyui/themes/icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/lightbox/css/lightbox.min.css') }}">

    <script src="{{ asset('assets/plugins/jquery-easyui/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-easyui/jquery.easyui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-easyui/plugins/jquery.edatagrid.js') }}"></script>
    <script src="{{ asset('assets/plugins/lodash/lodash.js') }}"></script>
    <script src="{{ asset('assets/plugins/lightbox/js/lightbox.min.js') }}"></script>
</head>

<body class="easyui-layout">
    <!--div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;">north region</div-->
    <div data-options="region:'west',split:true,title:'Menu'" style="width:200px;">
        <div class="easyui-accordion" style="width:100%;">
            <div title="Menu Utama" data-options="selected:true">
                <div class="easyui-panel" style="padding:5px;width: 100%;">
                    <ul id="tt" class="easyui-tree" data-options="
            url: '{{ url('api/get_menu') }}',
            method: 'get',
            animate: true,
                            onClick: function(e,node){
                                if(e.url != '#'){
                                    addPanel(e.id,e.text);
                                    load(e.id,e.url);
                                }
                            }
            ">
                    </ul>
                </div>
            </div>
            <div title="Menu User" style="padding:5px">
                <p>Hallo, User</p>
                <a href="javascript:void(0)" class="easyui-linkbutton l-btn l-btn-small" onclick="gantiPass()"
                    style="width:100%;height:34px;margin-bottom: 2px;">Ganti Password</a>
                <a href="javascript:void(0)" class="easyui-linkbutton l-btn l-btn-small"
                    onclick="window.location.href='#"
                    style="width:100%;height:34px" group="" id="">Logout</a>

            </div>
        </div>
    </div>

    <div data-options="region:'south',border:false" style="height:30px;padding:5px;">Copyright</div>
    <div data-options="region:'center',title:''">
        <div id="tab" class="easyui-tabs" style="width:100%;height:100%;border: none;">
            <div title="Dashboard" style="padding:10px;overflow:visible" id="dashboard">
                <div class="easyui-panel" style="width: 100%; height: 100%;border:none" id="page_00000000">

                </div>
            </div>
        </div>
    </div>

    <div id="dlg_ganti_password" class="easyui-dialog" modal="true" style="padding:10px 20px" closed="true"
        buttons="#dlg_ganti_password-buttons">
        <form id="fm_ganti_password" method="post">
            <div style="margin-bottom:20px">
                <input name="oldpass" id="oldpass" class="easyui-passwordbox" style="width: 300px;" required="true"
                    data-options="label:'Password Lama:',required : true" />
            </div>
            <div style="margin-bottom:20px">
                <input name="newpass" id="newpass" class="easyui-passwordbox" style="width: 300px;" required="true"
                    data-options="label:'Password Baru:',required : true" />
            </div>
            <div style="margin-bottom:20px">
                <input name="repass" id="repass" class="easyui-passwordbox" style="width: 300px;" required="true"
                    data-options="label:'Ulangi:',required : true" />
            </div>
        </form>
    </div>

    <div id="dlg_ganti_password-buttons">
        <div class="easyui-linkbutton" iconCls="icon-ok" onclick="savePass()">Save</div>
        <div class="easyui-linkbutton" iconCls="icon-cancel"
            onclick="javascript:$('#dlg_ganti_password').dialog('close')">Cancel</div>
    </div>

    <script type="text/javascript">
        function gantiPass() {
            $('#dlg_ganti_password').dialog('open').dialog('setTitle', 'Ganti Password');
            $('#fm_ganti_password').form('clear');
        }

        function savePass() {
            var newpass = $('#newpass').passwordbox('getValue');
            var repass = $('#repass').passwordbox('getValue');
            if (newpass != repass) {
                $.messager.show({
                    title: 'Error',
                    msg: 'Ulang Password tidak sama'
                });
                return;
            }

            $('#fm_ganti_password').form('submit', {
                url: 'login/gantiPass',
                onSubmit: function() {
                    return $(this).form('validate');
                },
                success: function(result) {
                    var result = eval('(' + result + ')');
                    if (result.success) {
                        $('#dlg_ganti_password').dialog('close'); // close the dialog
                        $.messager.show({
                            title: 'Success',
                            msg: 'Password Berhasil ubah'
                        });
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: result.msg
                        });
                    }
                }
            });
        }

        var index = 0;

        function addPanel(id, ttl) {
            index++;
            $('#tab').tabs('close', id + ' - ' + ttl);
            $('#tab').tabs('add', {
                title: id + ' - ' + ttl,
                id: id,
                content: '<div id="page_' + id +
                    '" class="easyui-panel" style="width: 100%; height: 100%;border:none"></div>',
                closable: true
            });
        }

        function removePanel() {
            var tab = $('#tab').tabs('getSelected');
            if (tab) {
                var index = $('#tab').tabs('getTabIndex', tab);
                $('#tab').tabs('close', index);
            }
        }

        function load(id, url) {
            $('#page_' + id).panel('refresh', url);
        }


        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            var h = date.getHours();
            var f = date.getMinutes();
            var s = date.getSeconds();
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
            //return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d) + ' ' + (h<10?('0'+h):h) + ':' + (f<10?('0'+f):f) + ':' + (s<10?('0'+s):s);
        }

        function myparser(s) {
            if (!s) return new Date();
            var ss = (s.split('/'));
            var d = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var y = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }

        function myformatter2(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            var h = date.getHours();
            var f = date.getMinutes();
            var s = date.getSeconds();
            //return (d<10?('0'+d):d) + '/' + (m<10?('0'+m):m) + '/' + y;
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y + ' ' + (h < 10 ? ('0' + h) :
                h) + ':' + (f < 10 ? ('0' + f) : f) + ':' + (s < 10 ? ('0' + s) : s);
        }

        function myparser2(s) {

            if (!s) return new Date();
            var ss = (s.split(' '));
            var sss = (ss[0].split('/'));
            var ssss = (ss[1].split(':'));
            var d = parseInt(sss[0], 10);
            var m = parseInt(sss[1], 10);
            var y = parseInt(sss[2], 10);
            var h = parseInt(ssss[0], 10);
            var f = parseInt(ssss[1], 10);
            var s = parseInt(ssss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d, h, f, s);
            } else {
                return new Date();

            }
        }

        function tglDdmmToMmdd(date) {
            var split = date.split('/');
            return split[1] + '/' + split[0] + '/' + split[2];
        }

        function getAge(dateString) {
            var now = new Date();
            var today = new Date(now.getYear(), now.getMonth(), now.getDate());

            var yearNow = now.getYear();
            var monthNow = now.getMonth();
            var dateNow = now.getDate();

            var dob = new Date(dateString.substring(6, 10),
                dateString.substring(0, 2) - 1,
                dateString.substring(3, 5)
            );

            var yearDob = dob.getYear();
            var monthDob = dob.getMonth();
            var dateDob = dob.getDate();
            var age = {};
            var ageString = "";
            var yearString = "";
            var monthString = "";
            var dayString = "";


            yearAge = yearNow - yearDob;

            if (monthNow >= monthDob)
                var monthAge = monthNow - monthDob;
            else {
                yearAge--;
                var monthAge = 12 + monthNow - monthDob;
            }

            if (dateNow >= dateDob)
                var dateAge = dateNow - dateDob;
            else {
                monthAge--;
                var dateAge = 31 + dateNow - dateDob;

                if (monthAge < 0) {
                    monthAge = 11;
                    yearAge--;
                }
            }

            age = {
                years: yearAge,
                months: monthAge,
                days: dateAge
            };

            if (age.years > 1) yearString = " years";
            else yearString = " year";
            if (age.months > 1) monthString = " months";
            else monthString = " month";
            if (age.days > 1) dayString = " days";
            else dayString = " day";
            return age;
        }
    </script>

</body>

</html>
