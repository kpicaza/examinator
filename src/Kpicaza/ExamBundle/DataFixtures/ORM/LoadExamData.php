<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace Kpicaza\ExamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Kpicaza\ExamBundle\Entity\Exam;
use Kpicaza\ExamBundle\Entity\Question;
use Kpicaza\ExamBundle\Entity\Answer;

class LoadExamData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

        for ($n = 1; $n <= 25; $n++) {
            $examAdmin = $this->createExam($manager, $n);
            $manager->persist($examAdmin);
            $manager->flush();
        }
    }

    protected function createExam(ObjectManager $manager, $n)
    {
        $materias = array('math', 'sciece', 'robotics', 'astronomy', 'biology');
        
        $examAdmin = new Exam();
        $examAdmin->setSubject(ucfirst($materias[mt_rand(0, 4)]) . ' exam: subject for test ' . $n);
        $examAdmin->setAccessCode($this->generateRandomString());
        $examAdmin->setDescription($this->generateDescription());
        $examAdmin->setToAprove(70);


        for ($y = 1; $y <= 10; $y++) {
            $questionAdmin = new Question();
            $questionAdmin->setQuestion('This is the question number ' . $y . '.');
            $points = array(10, 25, 50);
            $questionAdmin->setPoints($points[mt_rand(0, 2)]);
            $examAdmin->addQuestion($questionAdmin);
            $manager->persist($questionAdmin);
            $manager->flush();

            for ($z = 1; $z <= 4; $z++) {
                $isCorrect = (bool) mt_rand(0, 1);
                $string = array('false', 'true');
                $answerAdmin = new Answer();
                $answerAdmin->setAnswer('This is the answer number ' . $z . ' ' . $string[$isCorrect] . '.');
                $answerAdmin->setIsCorrect($isCorrect);
                $answerAdmin->setQuestion($questionAdmin);
                $manager->persist($answerAdmin);
            }
        }


        return $examAdmin;
    }

    /**
     * Generate random string as fake exam code.
     * 
     * @param type $length
     * @return type
     */
    protected function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return substr($randomString, 0, 4) . '-' . substr($randomString, 4);
    }

    
    
    
    protected function generateDescription()
    {
        $descriptions = array(
          'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una gale',
          'mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original.',
          'Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum',
          'Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras',
          'Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto'
        );
        
        return $descriptions[mt_rand(0, 3)];
    }
    
}
