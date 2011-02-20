{include file='header_lite.tpl'}
<table align="center" width="100%" cellpadding="2" cellspacing="0" class="content" border="0">
    <tr valign="top">
        <td>{get_user_menu prefix="<li style='white-space:nowrap'>"}</td>
        <td width="100%" class="content">
            <div class="page_name">News</div>
            {get_notification}
            <table width="100%" cellpadding="3">
                <tr>
                    <td class="head"><b>ID</b></td>
                    <td class="head"><b>Title</b></td>
                    <td class="head"><b>Text</b></td>
                    <td class="head"><b>Datetime</b></td>
                    <td class="head"><b>Actions</b></td>
                </tr>
                {foreach from=$news item=new}
                <tr>
                    <td class="list">{$new.id}</td>
                    <td class="list">{$new.title|escape}</td>
                    <td class="list">{$new.text|escape|nl2br}</td>
                    <td class="list">{$new.datetime|date_format:"%d.%m.%Y"}</td>
                    <td class="list">
                        <a href="{$smarty.server.PHP_SELF}?action=edit&id={$new.id}">Edit</a> |
                        <a href="{$smarty.server.PHP_SELF}?action=delete&id={$new.id}" onclick="return confirm('Do you realy want to delete it?')">Delete</a>
                    </td>
                </tr>
                {/foreach}
            </table>
            <br />
            <form action="{$smarty.server.PHP_SELF}" method="POST">
            <input type="hidden" name="action" value="save" />
            <input type="hidden" name="id" value="{$smarty.post.id}" />
            <table border="0" cellspacing="1">
                <tr>
                    <td>Datetime:</td>
                <td><input type="text" name="datetime" class="datepicker" value="{$smarty.post.datetime}" /></td>
                </tr>
                <tr>
                    <td>Title:</td>
                <td><input type="text" name="title" value="{$smarty.post.title|escape}" /></td>
                </tr>
                <tr>
                    <td>Text</td>
                <td><textarea name="text" rows="4" cols="20">{$smarty.post.text|escape|nl2br}</textarea></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="Save" class="button"></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>
{literal}
<script language="Javascript">
    $('.datepicker').css({'background':'#ffffff url(/images/calendar.gif) no-repeat right'});
    $(".datepicker").datepicker({
            dateFormat: "dd.mm.yy",
            firstDay: 1
    });
</script>
{/literal}