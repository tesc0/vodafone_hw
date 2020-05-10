<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class Site extends AbstractController
{

    /**
     * Main page, get list of contacts     *
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        $letters = [];

        // already existing users
        $users_ = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        $users = [];
        if(!empty($users_)) {
            foreach($users_ as $u) {
                $users[] = [
                    "id" => $u->getId(),
                    "firstname" => $u->getFirstname(),
                    "lastname" => $u->getLastname(),
                    "email" => $u->getEmail(),
                    "phone" => $u->getPhone()
                ];
            }
        }


        // get first letter of last names
        $letters_qb = $this->getDoctrine()
            ->getRepository(Users::class)
            ->createQueryBuilder('u');

        $letters_qb->select("SUBSTRING(u.lastname, 1, 1) as letter");
        $letters_qb->orderBy("SUBSTRING(u.lastname, 1, 1)");

        $query = $letters_qb->getQuery();
        $letters_ = $query->execute();

        $letters2 = [];

        if(!empty($letters_)) {
            foreach($letters_ as $l) {
                $letters2[$l["letter"]] = $l["letter"];
            }

            foreach($letters2 as $letter) {
                $letters[] = $letter;
            }
        }

        return $this->render('index.html.twig', ['users' => $users, 'letters' => $letters]);
    }

    /**
     * Save contact
     *
     * If id == 0, create, otherwise overwrite
     *
     *
     * @param int $id
     * @return mixed
     */
    public function save($id = 0) {

        $post = json_decode(file_get_contents('php://input'), true);

        if(!empty($post)) {

            if(!empty($post["lastname"]) && !empty($post["firstname"]) && !empty($post["email"]) && !empty($post["phone"])) {

                $email = filter_var($post["email"], FILTER_VALIDATE_EMAIL);

                $lastname = filter_var($post["lastname"], FILTER_SANITIZE_STRING);
                $firstname = filter_var($post["firstname"], FILTER_SANITIZE_STRING);
                $phone = filter_var($post["phone"], FILTER_SANITIZE_STRING);


                if(!empty($email)) {

                    $entityManager = $this->getDoctrine()->getManager();

                    if(!empty($id)) {
                        $user = $entityManager
                            ->getRepository(Users::class)
                            ->find($id);
                    } else {
                        $user = new Users();
                        $user->setCreatedAt(new \DateTime());
                    }

                    $user->setLastname(ucfirst(trim($lastname)));
                    $user->setFirstname(ucfirst(trim($firstname)));
                    $user->setEmail($email);
                    $user->setPhone($phone);

                    if(empty($id)) {
                        $entityManager->persist($user);
                    }
                    $entityManager->flush();

                    $data["success"] = 1;
                    $data["message"] = "Sikeres mentés!";
                    $data["class"] = "success";

                } else {

                    $data["success"] = 0;
                    $data["message"] = "Hibás email-cím!";
                    $data["class"] = "warning";
                }

            } else {

                $data["success"] = 0;
                $data["message"] = "Minden adat megadása kötelező!";
                $data["class"] = "warning";

            }


        } else {

            $data["success"] = 0;
            $data["message"] = "Nincs adat!";
            $data["class"] = "warning";
        }

        return $data;
    }

    /**
     * If post-data exists, save the new user
     * If not, load the empty html form
     *
     * @return JsonResponse|Response
     */
    public function create() {

        $request = Request::createFromGlobals();
        $post = $request->request->all();
        if(empty($post)) {
            $post = json_decode(file_get_contents('php://input'), true);
        }

        if(!empty($post)) {
            $result = $this->save(0);
            return new JsonResponse($result);
        } else {
            $user = [
                'id' => '',
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'phone' => ''
            ];
            return $this->render('form.html.twig', ['user' => $user]);
        }
    }

    /**
     * If post is empty load html form with the data of the selected user
     *  -> if the user cannot be found by id, redirect to main page
     * otherwise save the new details
     *
     * @param $id
     * @return JsonResponse|Response
     */
    public function change($id) {

        $post = json_decode(file_get_contents('php://input'), true);

        if(!empty($post)) {
            $result = $this->save($id);
            return new JsonResponse($result);
        } else {

            //if(!empty($id)) {
            //    $data["success"] = 0;
            //    $data["message"] = "Nincs adat!";
            //    $data["class"] = "warning";

            //    return new JsonResponse($data);
            //} else {

                $entityManager = $this->getDoctrine()->getManager();

                $user = $entityManager
                    ->getRepository(Users::class)
                    ->find($id);

                $user_r = [];
                if(!empty($user)) {
                    $user_r = [
                        "id" => $user->getId(),
                        "firstname" => $user->getFirstname(),
                        "lastname" => $user->getLastname(),
                        "email" => $user->getEmail(),
                        "phone" => $user->getPhone()
                    ];
                } else {
                    return $this->redirectToRoute("index");
                }

                return $this->render('form.html.twig', ['user' => $user_r]);
            //}
        }
    }

    /**
     * Delete the user
     * Hard delete, removes the row from the database table
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        if(!empty($id)) {

            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager
                ->getRepository(Users::class)
                ->find($id);
            $entityManager->remove($user);
            $entityManager->flush();

            $data["success"] = 1;
            $data["message"] = "Sikeres törlés.";
            $data["class"] = "success";


        } else {

            $data["success"] = 0;
            $data["message"] = "Nincs azonosító!";
            $data["class"] = "warning";
        }

        return new JsonResponse($data);
    }


    /**
     * Search function of the main page
     *
     * @return JsonResponse
     */
    public function search()
    {

        if(empty($post)) {
            $post = json_decode(file_get_contents('php://input'), true);
        }

        if(!empty($post)) {

            $keyword = trim($post["search"]);

            // soft search in every field
            $sql = '
        SELECT * FROM users u
        WHERE u.firstname LIKE :keyword OR u.lastname LIKE :keyword OR u.email LIKE :keyword OR u.phone LIKE :keyword';

            $conn = $this->getDoctrine()->getManager()->getConnection();

            $stmt = $conn->prepare($sql);
            $stmt->execute(['keyword' => '%' . $keyword . '%']);
            $result = $stmt->fetchAll();


            $data["success"] = 1;
            $data["result"] = $result;
            $data["message"] = "Keresés lefuttatva!";
            $data["class"] = "success";

        } else {

            $data["success"] = 0;
            $data["message"] = "Nincs adat!";
            $data["class"] = "warning";
        }

        return new JsonResponse($data);
    }

    /**
     * Filter by letter of last name
     *
     * @return JsonResponse
     */
    public function filter()
    {
        $post = json_decode(file_get_contents('php://input'), true);

        if(!empty($post)) {

            $letter = trim($post["letter"]);

            $sql = '
        SELECT * FROM users u
        WHERE SUBSTRING(u.lastname, 1, 1) LIKE :letter';

            $conn = $this->getDoctrine()->getManager()->getConnection();

            $stmt = $conn->prepare($sql);
            $stmt->execute(['letter' => $letter]);
            $result = $stmt->fetchAll();


            $data["success"] = 1;
            $data["result"] = $result;
            $data["message"] = "Keresés lefuttatva!";
            $data["class"] = "success";

        } else {

            $data["success"] = 0;
            $data["message"] = "Nincs adat!";
            $data["class"] = "warning";
        }

        return new JsonResponse($data);
    }
}