page = PAGE
	

page{



    typeNum=0

	includeCSSLibs{
		10= EXT:heiner/Resources/Public/Bootstrap/css/bootstrap.min.css
		20 = EXT:heiner/Resources/Public/fontawesome/css/all.css
		30 = EXT:heiner/Resources/Public/Css/sm-core-css.css
		40 = EXT:heiner/Resources/Public/Css/sm-simple.css
		50 = EXT:heiner/Resources/Public/Css/smartmenu.css
		css.media = all
   }

   includeCSS{
       
	  
		10=EXT:heiner/Resources/Public/Css/default.css
	}
includeJS{
		10 = EXT:heiner/Resources/Public/jQuery/js/jquery-3.3.1.slim.min.js

}
   includeJSFooterlibs{
     
       20=EXT:heiner/Resources/Public/Popper/js/popper.min.js
       30=EXT:heiner/Resources/Public/Bootstrap/js/bootstrap.min.js
		40 = EXT:heiner/Resources/Public/jQuery/js/jquery.smartmenus.min.js
		50= EXT:heiner/Resources/Public/jQuery/js/jquery-color-main/jquery.color.js
	  

	
   }

   includeJSFooter{
		
		20=EXT:heiner/Resources/Public/jQuery/js/customJSCompany.js
		30=EXT:heiner/Resources/Public/jQuery/js/smartmenus.js
	
		
   }

   config {
	  
		baseURL = /typo3
		doctype = html5
		
		#####################################
		# DEBUG - START
		#####################################
		debug = 1
		contentObjectExceptionHandler = 1
		#####################################
		# DEBUG - END
		#####################################
		
		#####################################
		# COMPRESSION - START
		#####################################
		compressCSS = 0
		compressJS = 0
		concatenateCss = 0
		concatenateJs = 0
		#####################################
		# COMPRESSION - END
		#####################################
		
		#####################################
		# PAGETITLE - START
		#####################################
		pageTitleFirst = 1
		pageTitleSeparator = -
		pageTitleSeparator.noTrimWrap = | | |
		#####################################
		# PAGETITLE - END
		#####################################
		
		#####################################
		# INDEXING / SEARCH - START
		#####################################
		index_enable = 1
		index_externals = 1
		index_metatags = 1
		#####################################
		# INDEXING / SEARCH - END
		#####################################
		
		#####################################
		# CACHE - START
		#####################################
		sendCacheHeaders = 0
		#####################################
		# CACHE - END
		#####################################
		
		#####################################
		# LANGUAGE - START
		#####################################
		sys_language_uid = 0
		sys_language_overlay = hideNonTranslated
		sys_language_mode = strict
		language = de
		locale_all = de-DE
		htmlTag_setParams = xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-DE"		
		#####################################
		# LANGUAGE - END
		#####################################
	}
	
	#Meta
	meta {
		viewport = width=device-width, initial-scale=1, shrink-to-fit=no
		
		#Google
		robots = noindex,nofollow
		google = notranslate
		
		#SEO
		description {
			field = description
		}
		
		author {
			field = author
		}
		
		keywords {
			field = keywords
		}
		
		copyright = Heiner Giehl
		
		#OpenGraph
		og:title {
			attribute = property
			field = title
		}
		og:site_name = Responsive TYPO3 Template
	   	og:site_name.attribute = property
	    dc.description {
	    	field = description
	    }	   
	    og:description {
	    	field = description
	    }
	    og:description.attribute = property
	    og:locale = de_DE
	    og:locale.attribute = property
	    og:locale:alternate {
    		attribute = property
        	value {
            	1 = de_DE
            	2 = en_GB
        	}
      	}

      	
      	X-UA-Compatible = IE=edge
	}

    10=FLUIDTEMPLATE
    10{
        templateName=Default
        layoutRootPaths {
        10 = EXT:heiner/Resources/Private/Layouts

    }
    partialRootPaths {
        10 = EXT:heiner/Resources/Private/Partials
    
    }
    templateRootPaths {
        10 = EXT:heiner/Resources/Private/Templates
    
    }

	variables{
		content0=CONTENT
		content0{
			table=tt_content 
			select.where=colPos=0
			select.orderBy=sorting
		}
	}
	
    }

    
}
plugin.tx_heiner_persons {
    view {
        templateRootPaths.0 = EXT:heiner/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_heiner_persons.view.templateRootPath}
        partialRootPaths.0 = EXT:heiner/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_heiner_persons.view.partialRootPath}
        layoutRootPaths.0 = EXT:heiner/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_heiner_persons.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_heiner_persons.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

plugin.tx_heiner_companies {
    view {
        templateRootPaths.0 = EXT:heiner/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_heiner_companies.view.templateRootPath}
        partialRootPaths.0 = EXT:heiner/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_heiner_companies.view.partialRootPath}
        layoutRootPaths.0 = EXT:heiner/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_heiner_companies.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_heiner_companies.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

# these classes are only used in auto-generated templates
plugin.tx_heiner._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-heiner table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-heiner table th {
        font-weight:bold;
    }

    .tx-heiner table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

// lib.dynamicContent = COA
// lib.dynamicContent {
// 	10 = LOAD_REGISTER
// 	10 {
// 		colPos.cObject = TEXT
// 		colPos.cObject {
// 			field = colPos
// 			ifEmpty.cObject = TEXT

// 		}
		
// 		pageUid.cObject = TEXT
// 		pageUid.cObject {
// 			field = pageUid
// 			ifEmpty.data = TSFE:id
// 		}
		
// 		contentFromPid.cObject = TEXT
// 		contentFromPid.cObject {
// 			data = DB:pages:{register:pageUid}:content_from_pid
// 			data.insertData = 1
// 		}
		
// 		wrap.cObject = TEXT
// 		wrap.cObject {
// 			field = wrap
// 		}
// 	}
	
// 	20 = CONTENT
// 	20 {
// 		table = tt_content
// 		select {
// 			includeRecordsWithoutDefaultTranslation = 1
// 			orderBy = sorting
// 			where = colPos={register:colPos}
// 			where.insertData = 1
// 			pidInList.data = register:pageUid
// 			pidInList.override.data = register:contentFromPid
// 		}
// 		stdWrap {
// 			dataWrap = {register:wrap}
// 		}
// 	}
	
// 	30 = RESTORE_REGISTER


	
// }





plugin.tx_felogin_pi1 {
	templateFile = EXT:heiner/Resources/Private/felogin/Templates/FrontendLogin.html
  view {
    templateRootPaths {
      0 = EXT:felogin/Resources/Private/Templates/
      100 = {$plugin.tx_felogin_pi1.view.templateRootPath}
    }


  }
}


ajax = PAGE

ajax {
typeNum = 100
	10 < tt_content.list.20.heiner_persons

config {
	contentObjectExceptionHandler = 0
disableAllHeaderCode = 1
xhtml_cleaning = 0
admPanel = 0
debug = 0
Disable default header "text/html"
disableCharsetHeader = 1
// Additional headers
additionalHeaders.10.header = Content-Type: application/json; charset=utf-8
additionalHeaders.10.replace = 1
}

}
ajaxCompanies = PAGE

ajaxCompanies {
typeNum = 99
	10 < tt_content.list.20.heiner_companies

config {
	contentObjectExceptionHandler = 1
disableAllHeaderCode = 1
xhtml_cleaning = 0
admPanel = 0
debug = 0
Disable default header "text/html"
disableCharsetHeader = 1
// Additional headers
additionalHeaders.10.header = Content-Type: application/json; charset=utf-8
additionalHeaders.10.replace = 1
}

}