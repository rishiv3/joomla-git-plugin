<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// Load up the git library
require_once('lib/git.php');
class plgSystemGit extends JPlugin {
	protected $autoloadLanguage = true;

	function onAfterRender() {
	
		// Load plugin called 'plugin_name'
		$table = new JTableExtension(JFactory::getDbo());
		$table->load(array('element' => 'git'));

		// Params can be changed like this
		if ($this->params['last_commit_time'] == "")
		{
		$time = date('Y-m-d H:i:s');
		$this->params['last_commit_time'] = $time;
		$table->set('params', $this->params->toString());
		// Save the change
		$table->store();
		}
		if ($this->params['last_push_time'] == "")
		{
		$time = date('Y-m-d H:i:s');
		$this->params['last_push_time'] = $time;
		$table->set('params', $this->params->toString());
		// Save the change
		$table->store();
		}

		// Setup variables
		$repo = new GitRepo(JPATH_ROOT);
		$repo->bin = $this->params->git_path);
		$active_branch = $repo->active_branch();

		// compare current time to last commit time
		$current_time = date('Y-m-d H:i:s');
		$git_commit_diff = round((strtotime($current_time) - strtotime($this->params->last_commit_time))/(60*60));
		
		//compare current time to last push time
		$git_push_diff = round((strtotime($current_time) - strtotime($this->params->last_push_time))/(60*60))
		
		if ($git_commit_diff >= $this->params->git_commit_frequency)
		{
			$commit_branch = trim($this->params->git_branch);
			if ($commit_branch != '' && $commit_branch != $active_branch)
			{
				// Need to stash changes before we checkout
				$repo->stash('save');
				// Now its a clean repo checkout the branch
				$repo->checkout($this->params->get('git_branch'));
				// Revert stashed changes
				$repo->stash('pop');
			}
			// Commit the changes to the branch
			$message = str_replace('[date]', date('Y-m-d H:i:s'), $this->params->git_message);
			$repo->commit($message);
			
			//update latest commit time
			$this->params['last_commit_time'] = $current_time;
			$table->set('params', $this->params->toString());
			$table->store();
		}
		if ($git_push_diff >= $this->params->git_push_frequency)
		{
			$remote_branch = trim($this->params->git_remote_branch);
			if ($remote_branch != '' && $remote_branch != $active_branch)
			{
				// Need to stash changes before we checkout
				$repo->stash('save');
				// Now its a clean repo checkout the branch
				$repo->checkout($this->params->get('git_branch'));
				// Revert stashed changes
				$repo->stash('pop');
			}
			$repo->push($this->params->git_remote, $this->params->git_remote_branch);
			
			//update latest push time
			$this->params['last_push_time'] = $current_time;
			$table->set('params', $this->params->toString());
			$table->store();
		}
	}
}
?>