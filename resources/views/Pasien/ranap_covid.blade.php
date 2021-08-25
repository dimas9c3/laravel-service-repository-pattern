<script type="text/javascript">
    $('#dg_pasien_covid_ranap').datagrid({
        columns: [
            [ {
                field: 'NAMAPASIEN',
                title: 'Nama Pasien',
                width: 200,
            }, {
                field: 'NOPASIEN',
                title: 'No Pasien',
                width: 200,
            },{
                field: 'PEKERJAAN',
                title: 'Pekerjaan',
                width: 200,
            }]
        ]
    });

    var url_pasien_ranap_covid;

    function newData_pasien_ranap_covid() {
        $('#dlg_pasien_ranap_covid').dialog('open').dialog('setTitle', 'New Data');
        $('#fm_pasien_ranap_covid').form('clear');
        url_pasien_ranap_covid = '{{ url("api/todo/save") }}';
    }

    function editData_pasien_ranap_covid() {
        var row = $('#dg_pasien_covid_ranap').datagrid('getSelected');
        console.log(row);
        if (row) {
            $('#dlg_pasien_ranap_covid').dialog('open').dialog('setTitle', 'Edit Data');
            $('#fm_pasien_ranap_covid').form('load', row);
            url_pasien_ranap_covid = '{{ url("api/todo/update") }}';
        }
    }

    function saveData_pasien_ranap_covid() {
        $('#fm_pasien_ranap_covid').form('submit', {
            url: url_pasien_ranap_covid,
            onSubmit: function () {
                $.messager.progress({
                    title: 'Please waiting',
                    msg: 'Loading data...'
                });
                return $(this).form('validate');
            },
            success: function (result) {
                if (!_.isNil(result)) {
                    result = JSON.parse(result);
                }

                $.messager.progress('close');
                if (result.status) {
                    $('#dlg_pasien_ranap_covid').dialog('close'); // close the dialog
                    $('#dg_pasien_covid_ranap').datagrid('reload'); // reload the Data data
                } else {
                    if (!_.isNil(result.message)) {
                        $.messager.show({
                            title: 'Error',
                            msg: result.message
                        });
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: 'Error server'
                        });
                    }

                }
            },
            onLoadSuccess: function () {
                $.messager.progress('close');
            },
            onLoadError: function () {
                $.messager.progress('close');
            },
        });
    }

    function removeData_pasien_ranap_covid() {
        var row = $('#dg_pasien_covid_ranap').datagrid('getSelected');
        if (row) {
            $.messager.confirm('Confirm', 'Are you sure you want to remove this Data?', function (r) {
                if (r) {
                    $.post('{{ url("api/todo/delete") }}', {
                        id: row.id
                    }, function (result) {
                        if (result.status) {
                            $('#dg_pasien_covid_ranap').datagrid('reload'); // reload the Data data
                        } else {
                            $.messager.show({ // show error message
                                title: 'Error',
                                msg: result.message
                            });
                        }
                    }, 'json');
                }
            });
        }
    }

    function doSearch(value, name) {
        // console.log('You input: ' + value+'('+name+')');
        $('#dg_pasien_covid_ranap').datagrid('load', {
            [name]: value
        });
    }

    $('#dg_pasien_covid_ranap').datagrid({
        onRowContextMenu: function (e) {
            e.preventDefault();
            $('#ingrid_pasien_ranap_covid').menu('show', {
                left: e.pageX,
                top: e.pageY
            });
        },
        onDblClickRow: function (e) {
            editData_pasien_ranap_covid();
        }
    });

</script>


<!-- FUNGSI KLIK KANAN -->
<div id="ingrid_pasien_ranap_covid" class="easyui-menu" style="width:120px;">
    <div data-options="iconCls:'icon-edit'" onclick="editData_pasien_ranap_covid()">Edit</div>
    <div data-options="iconCls:'icon-remove'" onclick="removeData_pasien_ranap_covid()">Remove</div>
    <div class="menu-sep"></div>
    <div data-options="iconCls:'icon-no'">Cancel</div>
</div>

<!-- FUNGSI TOOL BAR -->
<div id="toolbar_pasien_ranap_covid">
    <table width="100%">
        <tr>
            <td style="padding: 5px 10px">
                <div class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newData_pasien_ranap_covid()">New</div>
                <div class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editData_pasien_ranap_covid()">Edit
                </div>
                <div class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeData_pasien_ranap_covid()">
                    Remove</div>
            </td>
            <td style="padding: 5px 10px;text-align:right">
                <input class="easyui-searchbox" data-options="prompt:'Please Input Value',menu:'#mm',searcher:doSearch"
                    style="width:100%">
                <div id="mm">
                    <!-- <div data-options="name:'all', iconCls:'icon-ok'">All News</div> -->
                    <div data-options="name:'filter_nama_pasien'">Nama Pasien</div>
                    <div data-options="name:'filter_no_pasien'">No Pasien</div>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- Table -->
<table id="dg_pasien_covid_ranap" title="Data Pasien Covid Ranap" style="width: auto; height: auto;" url="{{ url('api/pasien') }}" method="GET"
    toolbar="#toolbar_pasien_ranap_covid" pagination="true" pageSize="20" rownumbers="true" fitColumns="true"
    singleSelect="true">
</table>

<div id="dlg_pasien_ranap_covid" class="easyui-dialog" modal="true" style="padding:10px 20px" closed="true"
    buttons="#dlg_pasien_ranap_covid-buttons">
    <form id="fm_pasien_ranap_covid" method="post" enctype="multipart/form-data" novalidate>
        <div style="margin-bottom:20px; display: none;">
            <input name="id" class="easyui-textbox" style="width: 300px;" data-options="label:'Id:'" />
        </div>
        <div style="margin-bottom:20px">
            <input name="todo_name" class="easyui-textbox" style="width: 300px;"
                data-options="label:'Todo:',required : true" />
        </div>
        <div style="margin-bottom:20px">
            <input name="todo_image" class="easyui-filebox" style="width: 300px;" data-options="label:'Todo Image:'" />
        </div>
    </form>
</div>

<div id="dlg_pasien_ranap_covid-buttons">
    <div class="easyui-linkbutton" iconCls="icon-ok" onclick="saveData_pasien_ranap_covid()">Save</div>
    <div class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg_pasien_ranap_covid').dialog('close')">
        Cancel</div>
</div>
