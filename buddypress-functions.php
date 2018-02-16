<?php
// all buddypress functions and conditional tags (условные тэги)
// https://codex.buddypress.org/developer/template-tag-reference/

// настройки buddypress
// https://codex.buddypress.org/getting-started/customizing/changing-internal-configuration-settings/

// проверяет находимся ли мы на странице http://dugoodr.dev/members/
bp_is_members_component()
// проверяет находимся ли мы на страницах пользователя http://dugoodr.dev/members/din-vinchester/*
bp_is_user()

if( bp_is_members_component() || bp_is_user() ) {  echo "<h1> you in members or user's area =777= </h1>"; }

// получение user_id только на странице http://dugoodr.dev/members/
bp_get_member_user_id();

// получение user_id только на страницах пользователя http://dugoodr.dev/members/din-vinchester/*
// но не работает на http://dugoodr.dev/members/
global $wpdb,$bp;
echo $user_id = $bp->displayed_user->id;

/* *********** */
echo "bp_is_directory()-"; var_dump(bp_is_directory()); // example: true if http://dugoodr.dev/causes/
echo "// bp_is_user_groups()-"; var_dump(bp_is_user_groups()); // example: true if http://dugoodr.dev/members/admin7/groups/

/* **** как переименовать страницу groups на другую ******* */
1. Add following to bp-custom.php file (create one if you don’t have one)
`define ( ‘BP_GROUPS_SLUG’, ‘teams’ );`
2. Create a new Page named Teams
3. Go to BuddyPress > Pages and associate Groups with the page Teams

// получить slug группы, текущий компонент,текущий action и все созданные страницы pages
$slug = $bp->groups->slug;
$root_slug = $bp->groups->root_slug;
$current_component = $bp->current_component;
$current_action = $bp->current_action;
echo "PAGES "; print_r($bp->pages);
echo "<h1>=== 777 slug-{$slug} / root_slug-{$root_slug} / current_component-{$current_component}
/ current_action-{$current_action}</h1>";

/**********************/
$bp->members->slug; // выводит- members
// выводит например- new_members...это page_name  (если компонент ассоциировали с нестандартной страницей в http://dugoodr.dev/wp-admin/admin.php?page=bp-page-settings)
$root_slug = $bp->members->root_slug;
$uri = $_SERVER['REQUEST_URI'];  // /members/admin7/groups/
$has_members_slug = preg_match("/{$root_slug}/i", $uri);
$has_groups_slug = preg_match("/groups/i", $uri);

if($has_members_slug && $has_groups_slug) {
	// echo "is groups!";
	get_template_part("404");
	exit;
}

// $bp->pages->groups = false; // группы не будут показываться

/***** получить все данные по id поля *****************/

// tab Security field Description,wich id=44
$sec_verify_desc = xprofile_get_field(44, $user_id);
// default description under field
$sec_verify_desc = $sec_verify_desc->description;

/***** добавить пагинацию внутри цикла группы (с members также работает) *****/
<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' )."&per_page=3" ) ) : ?>

<?php
/* *********** Group Extension API (creation new section for group settings)
создание новой секции настроек для группы ************ */

/**
 * The bp_is_active( 'groups' ) check is recommended, to prevent problems 
 * during upgrade or when the Groups component is disabled
 */
if ( bp_is_active( 'groups' ) ) :
  
class Group_Extension_Example_2 extends BP_Group_Extension {
    /**
     * Here you can see more customization of the config options
     */
    function __construct() {
        $args = array(
            'slug' => 'group-extension-example-2',
            'name' => 'Group Extension Example 2',
            'nav_item_position' => 105,
            'show_tab' => 'noone',
            'screens' => array(
                'edit' => array(
                    'name' => 'GE Example 2',
                    // Changes the text of the Submit button
                    // on the Edit page
                    'submit_text' => 'Submit, suckaz',
                ),
                'create' => array(
                    'position' => 100,
                ),
            ),
        );
        parent::init( $args );
    }
 
    function display( $group_id = NULL ) {
        $group_id = bp_get_group_id();
        echo 'This plugin is 2x cooler!';
    }
 
    function settings_screen( $group_id = NULL ) {
        $setting = groups_get_groupmeta( $group_id, 'group_extension_example_2_setting' );
        $setting_2 = groups_get_groupmeta( $group_id, 'gr_ext_exm_2_enable' );
 
        ?>
        Save your plugin setting here: 
        <input type="text" name="group_extension_example_2_setting" value="<?php echo esc_attr( $setting ) ?>" />
		<label for="gr_ext_exm_2_enable">
		<input type="checkbox" id="gr_ext_exm_2_enable" name="gr_ext_exm_2_enable" <?php if($setting_2 == 'yes') echo 'checked="checked"';?>value="yes"> Enable automate
		</label>
		<script type="text/javascript">
			jQuery(document).ready(function(){
			var sel = jQuery('#gr_ext_exm_2_enable');
			sel.on('click', function(){     
			if(sel.attr("checked") == 'checked') {  
				sel.val("yes")
			} else {
				sel.val("no")
			}
			});
		});
		</script>
        <?php
    }
 
    function settings_screen_save( $group_id = NULL ) {
        $setting = isset( $_POST['group_extension_example_2_setting'] ) ? $_POST['group_extension_example_2_setting'] : '';
        groups_update_groupmeta( $group_id, 'group_extension_example_2_setting', $setting );
        $setting_2 = isset( $_POST['gr_ext_exm_2_enable'] ) ? $_POST['gr_ext_exm_2_enable'] : '';
        groups_update_groupmeta( $group_id, 'gr_ext_exm_2_enable', $setting_2 );
    }
 
    /**
     * create_screen() is an optional method that, when present, will
     * be used instead of settings_screen() in the context of group
     * creation.
     *
     * Similar overrides exist via the following methods:
     *   * create_screen_save()
     *   * edit_screen()
     *   * edit_screen_save()
     *   * admin_screen()
     *   * admin_screen_save()
     */
    function create_screen( $group_id = NULL ) {
        $setting = groups_get_groupmeta( $group_id, 'group_extension_example_2_setting' );
 
        ?>
        Welcome to your new group! You are neat.
        Save your plugin setting here: 
        <input type="text" name="group_extension_example_2_setting" value="<?php echo esc_attr( $setting ) ?>" />
		<label for="gr_ext_exm_2_enable">
		<input type="checkbox" id="gr_ext_exm_2_enable" name="gr_ext_exm_2_enable" value="yes"> Enable automate
		</label>
        <?php
    }
 
}
bp_register_group_extension( 'Group_Extension_Example_2' );
 
endif;

/* *********** Group Extension API ************ */

/******* создание нового пункта в меню группы *********/

// function bp_core_create_nav_link( $args = '', $component = 'members' ) 
// add_action( 'bp_core_create_nav_link', $r, $args, $defaults, $component );  // original bp code
add_action( 'bp_core_create_nav_link', "a21_777",100,4 );
function a21_777($r, $args, $defaults, $component){

if( bp_is_group() ):
// будет добавлена новая ссылка только на странице группы test-group-test!!!
	
    // [name] => Profile
    // [slug] => profile
    // [item_css_id] => xprofile
    // [show_for_displayed_user] => 1
    // [site_admin_only] => 
    // [position] => 20
    // [screen_function] => xprofile_screen_display_profile
    // [default_subnav_slug] => public

	global $bp;
	$group_id = $bp->groups->current_group->id;
	$group = groups_get_group($group_id);
	
    $component = "groups";
	$nav_item = array(
		'name'                    => "as21 new link",
		'slug'                    => 'causes',
		'parent_slug' 		  => 'test-group-test', // $group->slug (for example 'settings','proifle')
		'link'                    => "http://ya.ru",
		'css_id'                  => "dddddddd",
		'show_for_displayed_user' => 1,
		'position'                => 100,
		// 'screen_function'         => "my_profile_page_function_to_show_screen",
		'secondary' => 1,
		'user_has_access' => 1
	);

	// Add the item to the nav.
	buddypress()->{$component}->nav->add_nav( $nav_item );

	// echo "===debug a21=== url script: a21_777<br>";
	// echo $component;
	// alex_debug(1,1,"r ",$r);
	// alex_debug(0,1,"args ",$args);
	// alex_debug(0,1,"defaults ",$defaults);
	return $nav_item;
endif;
}
//or

function my_bp_nav_adder() {

    global $bp;

    bp_core_new_nav_item( array(
    'name' => '111',
    'slug' => 'public',
    'default_subnav_slug' => 'settings',
    // 'screen_function' => 'bp_media_privacy_link','position' => 75,// 'user_has_access' => bp_is_my_profile()
    ) );

}

add_action( "bp_setup_nav", "my_bp_nav_adder" );

/******* создание нового пункта в меню группы *********/

/* **** as21 еще один способ получения данных вне цикла через статические методы **** */
$groups = BP_Groups_Group::get(array('type'=>'alphabetical'));
alex_debug(0,1,'',$groups);
/* **** as21 еще один способ получения данных вне цикла через статические методы **** */



/* **** as21 buddypress add custom page tab (beside activity,profile,groups etc) **** */

add_action( 'bp_setup_nav', 'my_bp_nav_adder', 50 );

function my_bp_nav_adder() {
    global $bp;
    bp_core_new_nav_item(
            array(
                    'name'                => __( 'Listings', 'buddypress' ),
                    'slug'                => 'my-listings',
                    'position'            => 1,
                    'screen_function'     => 'listingsdisplay',
                    'default_subnav_slug' => 'my-listings',
                    'parent_url'          => $bp->loggedin_user->domain . $bp->slug . '/',
                    'parent_slug'         => $bp->slug,
                    // 'show_for_displayed_user' => false,
                    // 'site_admin_only'         => true, 
            ) );
}

function listingsdisplay() {
    //add title and content here - last is to call the members plugin.php template
    add_action( 'bp_template_title', 'my_groups_page_function_to_show_screen_title' );
    add_action( 'bp_template_content', 'my_groups_page_function_to_show_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function my_groups_page_function_to_show_screen_title() {
    echo 'My new Page Title';
}

function my_groups_page_function_to_show_screen_content() {
    echo 'My Tab content here';

}


/* **** as21 buddypress add custom page tab (beside activity,profile,groups etc) **** */


/* **** as21 bp edit (name,position etc) tab or nav **** */

function bpcodex_change_nav_tabs() {

    buddypress()->members->nav->edit_nav( array(
        'position' => 999,
        'name' => 'Mijn aankopen'
    ), 'shop' );

    buddypress()->members->nav->edit_nav( array(
        'name' => 'Shopping Cart'
    ), 'cart','shop' ); // subnav

    buddypress()->members->nav->edit_nav( array(
        'name' => ' Track your order'
    ), 'track','shop' );

}
add_action( 'bp_setup_nav', 'bpcodex_change_nav_tabs', 100 );