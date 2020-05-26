<?php
$arraySession = array(
    $this->session->show('add_article'), 
    $this->session->show('edit_article'), 
    $this->session->show('delete_article'), 
    $this->session->show('add_comment'), 
    $this->session->show('flag_comment'), 
    $this->session->show('delete_comment'),
    $this->session->show('edit_comment'),
    $this->session->show('register'), 
    $this->session->show('login'), 
    $this->session->show('logout'), 
    $this->session->show('delete_account')
);

foreach ($arraySession as $element)
{
    if($element !== null)
    {
        ?>
            <div class="alert alert-primary alert-dismissible fade show showSession" role="alert">
                <?= $element ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
    }
}

// test

class ShowSession

{
    private $sessions = [];

    public function __construct(Array $session)
    {
    }

    /** 
     * @var string
     */
    public function getSession()
    {
        return $this->sessions;
    }

    /**
     * @param string $session
     */
    public function setSession($sessions)
    {
        if(isset($sessions))
        {
            foreach($sessions as $session)
            {
                $session = '$this->session->show(' . $session . ')';
            }
        }
    }

    public function showSession($sessions)
    {
                ?>
                    <div class="alert alert-primary alert-dismissible fade show showSession" role="alert">
                        <?= $element ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
    }

}
?>