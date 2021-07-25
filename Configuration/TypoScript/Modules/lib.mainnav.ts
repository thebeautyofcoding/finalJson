lib.mainnav = HMENU
lib.mainnav {
	wrap = <ul id="main-menu" class="sm sm-simple">|</ul>

	1 = TMENU
	1 {
		expAll = 1

		NO = 1
		NO {
			wrapItemAndSub = <li class="LevelOne">|</li>
			stdWrap.htmlSpecialChars = 1
			ATagTitle.field = description // subtitle // title
		}
	}

	2 < .1
	2.wrap = <ul>|</ul>

	3 < .2
	4 < .2
	5 < .2
}