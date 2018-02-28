<?php

/**
 * The view file for the "site/view" action.
 *
 * @var \yii\web\View $this Current view instance.
 * @see \kodi\frontend\controllers\SiteController::actionView()
 */

$this->title = Yii::t('frontend', 'Press');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/styles/site/press.css');
$this->registerJs("
var navButton = Array.from(document.querySelectorAll('.navlink'));
var content = Array.from(document.getElementById('content').children);
navButton.forEach(function (elem) {
	elem.addEventListener('click', function (event) {
		var link = event.target;
		navButton.forEach(function (el) {
			if (link !== el) {
				el.classList.remove('active');
			}
		});
		content.forEach(function (elem) {
			elem.classList.add('hide');
			elem.classList.remove('show');
			if (elem.classList.contains(link.dataset.content)) {
				elem.classList.add('show');
			}
		});
		link.classList.add('active');
	});
});
");
?>

<section class="kodi">
    <div class="close">
        <a href="#">
            <img src="/styles/img/cros.svg">
        </a>
    </div>
    <nav>
        <ul>
            <li data-content="kit" class="navlink active">Press Kit</li>
            <li class="separator"></li>
            <li data-content="facts" class="navlink">Quick Facts</li>
        </ul>
    </nav>
    <div id="content" class="content">
        <div class="kit show">
            <div class="picture">
                <img src="/styles/img/man.svg">
            </div>
            <div class="button-group">
                <button>press image</button>
                <button>press release</button>
            </div>
        </div>
        <div class="facts hide">
            <div class="fact">
                <div class="title">date</div>
                <div class="bottom-separator"></div>
                <div class="description">
                    <p>September 2017</p>
                </div>
            </div>
            <div class="fact">
                <div class="title">founders</div>
                <div class="bottom-separator"></div>
                <div class="description">
                    <p>Alessandro Specchio - Director & Founder</p>
                    <p>Ivan Specchio - Lead Desin & Co-founder</p>
                </div>
            </div>
            <div class="fact">
                <div class="title">headquarters</div>
                <div class="bottom-separator"></div>
                <div class="description">
                    <p>Rome, Italy</p>
                    <p>Saint Petesburg, Russia</p>
                </div>
            </div>
            <div class="fact">
                <div class="title">advisors</div>
                <div class="bottom-separator"></div>
                <div class="description">
                    <p>Osvaldo Glatt</p>
                    <p>Clinton Donnelly</p>
                </div>
            </div>
            <div class="fact">
                <div class="title">products</div>
                <div class="bottom-separator"></div>
                <div class="description">
                    <p>KodiPlus - Free</p>
                </div>
            </div>
        </div>
    </div>
</section>
