<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$title = $_POST['title'];
		$text = $_POST['text'];
		$owner = $_POST['owner'];
		$backgroundColor = $_POST['backgroundColor'];
		$textColor = $_POST['textColor'];
		$filename = $_POST['filename'];
		$created = $lastUpdated = date('Y-m-d H:i:s');
		$column = 'to-do';

		if (empty($filename)) {
			$filename = $title . '_' . time() . '.json';
		} else {
			$filepath = __DIR__ . '/cards/' . $filename;
			if (file_exists($filepath)) {
				$existingStory = json_decode(file_get_contents($filepath), true);
				$created = $existingStory['created'];
				$column = $existingStory['column'];
			}
		}

		$story = [
			'column' => $column,
			'title' => $title,
			'text' => $text,
			'owner' => $owner,
			'backgroundColor' => $backgroundColor,
			'textColor' => $textColor,
			'created' => $created,
			'lastUpdated' => $lastUpdated
		];

		file_put_contents(__DIR__ . '/cards/' . $filename, json_encode($story, JSON_PRETTY_PRINT));
		$story['filename'] = $filename;
		echo json_encode($story);
	}
