<?php
/**
 * User interface provided by the module.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div id="server-login" style="margin-top:5px;">
    
    <?php
    if ($type == 'logout')
    {
        if ($params->get('greeting'))
        {
            echo '<div>';
            if ($params->get('name'))
            {
                echo $user->get('name');
            }
            else
            {
                echo $user->get('username');
            }
            echo '</div>';
        }
        ?>

        <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
            <div class="logout-button">
                <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="user.logout" />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </form>

        <?php
    }
    else
    {

        echo $params->get('pretext');

        echo '<a href="' . JRoute::_('secured.php') . '">';

        if ($display_icon)
        {
            echo '<img src="' . JURI::base() . 'modules/mod_login_server/tmpl/icon.gif" alt="' . $link_text . '" />';
        }
        else
        {
            echo $link_text;
        }
        echo '</a>';

        echo $params->get('posttext');
    }
    echo '</div>';