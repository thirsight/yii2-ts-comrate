<?php

namespace ts\comrate\widgets;

use yii\helpers\Html;
use yii\helpers\Json;

/**
 * @see clientOptions http://v3.bootcss.com/javascript/#popovers
 *
 * @author Haisen <thirsight@gmail.com>
 * @since 1.0
 */
class CommentForm extends \yii\bootstrap\Widget
{
    public $urlCreateComment;

    public function init()
    {
        parent::init();

        $this->clientOptions = array_merge([
            'container' => 'body',
            'title' => 'Leave a comment',
            'placement' => 'bottom',
            'trigger' => 'click',
            'html' => true,
            'template' => '<div class="popover" role="tooltip" style="width:360px;max-width:360px;">
                <div class="arrow"></div>
                <h3 class="popover-title"></h3>
                <div class="popover-content"></div>
            </div>',
        ], $this->clientOptions);
    }

    public function run()
    {
        $this->renderPopover();
    }

    protected function renderPopover()
    {
        if (empty($this->clientOptions['content'])) {
            $this->clientOptions['content'] = <<<EOD

<form name="leave-a-comment">
    <input type="hidden" name="pk" value="">
    <div class="form-group">
        <textarea class="form-control" name="content" rows="4"></textarea>
    </div>
    <button type="button" class="btn btn-default btn-sm" name="submit">Submit</button>
    <button type="button" class="btn btn-link btn-sm" data-dismiss="popover">Cancel</button>
    <span class="text-danger hide">Please entry content.</span>
    <span class="text-success hide">Comment has been post.</span>
</from>
EOD;
        }

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = <<<EOD

jQuery("body").popover($options);
jQuery('{$this->clientOptions['selector']}').on("shown.bs.popover", function() {
    var oBtn = $(this);
    var oTip = oBtn.data("bs.popover").tip();
    var pk = oBtn.data("pk");
    oTip.find("input[name='pk']").val(pk);
    oTip.find("[data-dismiss='popover']").on("click", function () {
        oBtn.trigger("click");
    });
    oTip.find("button[name='submit']").on("click", function () {
        var oForm = oTip.find("form");
        var oFields = oForm.serializeArray();
        oForm.find("span").addClass("hide");

        if (jQuery.trim(oFields[1].value) == "") {
            oForm.find("span.text-danger").removeClass("hide");
        } else {
            jQuery.get("{$this->urlCreateComment}", oFields, function(msg) {
                if (jQuery.isNumeric(msg)) {
                    oForm.find("span.text-success").removeClass("hide");
                    oForm.find("textarea").prop("disabled", true);
                } else {
                    alert(msg);
                }
            });
        }
    });
});
EOD;
            $this->view->registerJs($js);
        }
    }
}
