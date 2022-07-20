<?php

include 'freelancer_crawl.php';

use Ponisha_Crawl\Project;
use function Ponisha_Crawl\get_page;

function get_projects(int $number_of_pages = 5)
{
    $projects = [];
    for ($page = 1; $page <= $number_of_pages; $page++) {
        $res_content = get_page($page);
        $res_objs = json_decode($res_content, associative: true)['items'];

        $projects_array = $res_objs['data'];

        foreach ($projects_array as $project_raw) {
            $project = new Project(
                $project_raw['id'],
                $project_raw['title_slug'],
                $project_raw['description'],
                $project_raw['amount_min'],
                $project_raw['amount_max'],
                $project_raw['bidding_closed_date']['date'],
                $project_raw['bids_number'],
            );
            array_push($projects, $project);
        }
    }

    return $projects;
}

$number_of_pages = $_GET['pages'] ?? 2;

$projects = get_projects($number_of_pages);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponisha-Projects</title>
    <link rel="stylesheet" , href="style.css" />

</head>

<body dir="rtl">
<form method="GET"> 
<input type="number" max="100", name="pages", value="5">
<input type="submit">
</form>
    <table>
        <thead>
            <th>title</th>
            <th>Price</th>
            <th>Date</th>
            <th>Bid</th>
            <th>Description</th>
        </thead>
        <tbody>
            <?php foreach ($projects as $project) : ?>
                <tr>
                    <td>
                        <a href=<?php echo $project->get_url(); ?>>
                            <?php echo $project->title; ?>
                        </a>
                    </td>
                    <td><?php echo $project->get_amount_range(); ?></td>
                    <td><?php echo $project->bids_close_date; ?></td>
                    <td><?php echo $project->bids_number; ?></td>
                    <td><?php echo $project->description; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>
</table>
