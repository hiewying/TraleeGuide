<?php
    namespace App\Controller;

    use App\Entity\Activity;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class ActivityController extends Controller{
        /**
         * @Route("/", name="activity_list")
         * @Method({"GET"})
         */
        public function index(){
            
            $activities = $this->getDoctrine()->getRepository(Activity::class)->findAll();

            return $this->render('activity/index.html.twig', array('activities' => $activities));
        }

        /**
         * @Route("/activity/new", name="new_activity")
         * Method({"GET", "POST"})
         */
        public function new(Request $request){
            $activity = new Activity();

            $form = $this->createFormBuilder($activity)
                    ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
                    ->add('description', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                    ->add('location', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                    ->add('openingHours', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))

                    ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))

                    ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $activity = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($activity);
                $entityManager->flush();

                return $this->redirectToRoute('activity_list');

            }

            return $this->render('activity/new.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/activity/{id}", name="activity_show")
         */
        public function show($id){

            $activity = $this->getDoctrine()->getRepository(Activity::class)->find($id);

            return $this->render('activity/show.html.twig', array('activity'=> $activity));
        }

          /**
         * @Route("/activity/edit/{id}", name="edit_activity")
         * Method({"GET", "POST"})
         */
        public function edit(Request $request, $id){
            $activity = new Activity();

            $activity = $this->getDoctrine()->getRepository(Activity::class)->find($id);

            $form = $this->createFormBuilder($activity)
                    ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
                    ->add('description', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                    ->add('location', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))
                    ->add('openingHours', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control')))

                    ->add('save', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))

                    ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('activity_list');

            }

            return $this->render('activity/edit.html.twig', array('form' => $form->createView()));
        }

        /**
         * @Route("/activity/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id){

            $activity = $this->getDoctrine()->getRepository(Activity::class)->find($id);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();

            $response = new Response();
            $response->send();

            $this->addFlash(
                'notice',
                'Note: Activity Removed'
            );
        }

        // /**
        //  * @Route("/activity/save")
        //  */
        // public function save(){
        //     $entityManager = $this->getDoctrine()->getManager();

        //     // $activity = new Activity();
        //     // $activity->setName('SuperValu');
        //     // $activity->setDescription('SuperValu is a supermarket chain that operates on the island of Ireland.');
        //     // $activity->setLocation('Tralee Town Centre');
        //     // $activity->setOpeningHours('Mon-Sun: 9:00am - 11.00pm');

        //     $activity = new Activity();
        //     $activity->setName('Tennis');
        //     $activity->setDescription('Tennis is a racket sport that can be played individually against a single opponent or between two teams of two players each.');
        //     $activity->setLocation('Tralee Sports Complex');
        //     $activity->setOpeningHours('Mon-Wed: 5:00pm - 7.00pm');

        //     $entityManager->persist($activity);

        //     $entityManager->flush();

        //     return new Response('Saves an activity with the id of '.$activity->getId());

        // }
    }

?>