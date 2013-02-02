<?php

namespace Habari;

class RevsPlugin extends Plugin
{

	/**
	 * @param FormUI $form
	 * @param Post $post
	 */
	public function action_form_publish($form, $post) {
		$revisions = $form->publish_controls->append( 'fieldset', 'revisions', _t( 'Revisions' ) );

		$revs = $post->list_revisions();
		$out = '<ol>';
		foreach($revs as $rev => $user_id) {
			$out .= '<li><a href="' . URL::get('admin', array('page'=>'publish', 'id'=>$post->id, 'rev' => $rev)) .'">' . DateTime::create($rev)->format('Y-m-d H:i:s') . ' by ' . User::get_by_id($user_id)->displayname . '</a></li>';
		}
		$out .= '</ol>';

		$revisions->append( new FormControlStatic('revs', $out));
	}

	public function action_admin_publish_post($post) {
		if($post->id != 0 && isset($_GET['rev'])) {
			$post->set_revision($_GET['rev']);
		}
	}

}

?>