<?php 

add_action('admin_head', 'admin_styling');

function admin_styling() {
  echo '<style>
    /* Kill info box from post type order plugin */
    #cpt_info_box {
      display: none !important;
    }
    /* ACF flexible content */
  	#acf_after_title-sortables > .postbox.acf-postbox {
      background: transparent;
      box-shadow: none;
      border: 0px;
  	}
  	#acf_after_title-sortables > .postbox.acf-postbox .acf-fields > .acf-field-flexible-content {
  		padding: 0px;
  	}
  	.acf-oembed .title {
  		overflow: hidden;
  	}
  	.acf-flexible-content .layout .acf-fc-layout-handle {
  		background-color: aliceblue;
  		font-weight: bold;
  	}
  	#acf_after_title-sortables h2.ui-sortable-handle {
  		background-color: skyblue;
  	}
  	#acf_after_title-sortables .acf-fields .acf-field-flexible-content > .acf-label:first-child {
  		display: none;
  	}
  	#acf_after_title-sortables p.description {
		font-size: 12px;
		color: #b9b9b9;
		font-style: normal;
  	}
  	.acf-flexible-content .layout .acf-fc-layout-order {
  		opacity: 0.5;
  		background-color: transparent;
  		position: relative;
  		top: -1px;
  		left: -8px;
  	}
  	.acf-flexible-content .layout .acf-fc-layout-controlls .acf-icon.-collapse {
  		background-color: transparent;
  	}
  	#acf_after_title-sortables .acf-fields .acf-field .acf-label label {
		font-weight: normal;
		color: gray;
  	}
    .acf-fields > .acf-field.acf-field-flexible-content {
      background-color: transparent;
    }


    /* ACF table repeater */
    #acf_after_title-sortables .acf-field-repeater .acf-repeater .acf-table {
      border: 0px;
      background-color: transparent;
    }
    #acf_after_title-sortables .acf-field-repeater .acf-repeater .acf-table tbody.ui-sortable {
      display: block;
      background: white;
      border: 0px solid black;
    }
    #acf_after_title-sortables .acf-field-repeater .acf-repeater .acf-table tr.acf-row {
      display: block;
      margin-bottom: 25px;
      border: 1px solid #e1e1e1;
    }
    #acf_after_title-sortables .acf-field-repeater .acf-repeater .acf-table tr.acf-row td.acf-fields {
      width: 100%;
    }
    .acf-repeater .acf-row-handle.order {
      background-color: aliceblue;
    }


    /* ACF message */
    .acf-field.acf-field-message {
      background-color: #f5f5f5 !important;
      border: 1px solid #dadada !important;
    }
    .acf-field-message img {
      width: 100%;
    }
    .acf-field-message .acf-input p:first-child {
      margin-top: 0px;
    }
    .acf-field-message .acf-input p {
      color: #bbbaba;
      font-size: 12px;
    }
    .acf-field-message .acf-label {
      margin-top: 10px;
      margin-bottom: 0px;
    }


    /* ACF general */
    .acf-fields > .acf-field {
      background-color: white;
    }
    .acf-editor-wrap.delay .wp-editor-area {
      height: auto !important;
      min-height: 100px;
    }
  </style>';
}