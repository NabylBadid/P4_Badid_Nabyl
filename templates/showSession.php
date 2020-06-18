<?php
function showSession(array $arraySession)
{
    foreach ($arraySession as $element)
    {
        if($element !== null)
        {
            ?>
                <div class="alert alert-primary alert-dismissible fade show showSession" role="alert">
                    <?= $element; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
        }
    }
}

