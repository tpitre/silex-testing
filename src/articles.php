<?php

$blog = $app['controllers_factory'];
$blog->get('/articles/{slug}', function ($slug) use ($app) {

  // Fetch the JSON from our external service. Basic error checking for the
  // status code ensures we're looking at the right thing
  $response = $app['guzzle']->request('GET', 'http://7da-ecl.chromatic.is/api/node/article/' . $slug . '?_format=api_json');
  if ($response->getStatusCode() !== 200) {

  }

  // Everythign went well, get the JSON body
  $json = (string)$response->getBody();

  $data = json_decode($json, true);

  //print_r($data['data'][0]);

  return $app['twig']->render('articles.html.twig', array(
    'article' => $data['data'],
  ));

  // Okay, we got some JSON back from a remote URL.
  // Now we could call something like Mustache::render() to display it to the page
  // For now I've just returned some placeholder.
  //return 'This could be <code>{{ Mustache }}</code>, swapped out with the following json, <pre>'.$json;
});

return $blog;
