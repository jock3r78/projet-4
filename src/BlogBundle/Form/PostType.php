<?php

namespace BlogBundle\Form;

use BlogBundle\Entity\Category;
use BlogBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user = $options['user'];
        if($this->user == 'Jeanforteroche'){
            $builder
                ->add('name', TextType::class)
                ->add('content', TextareaType::class)
                ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name'])
                ->add('user', EntityType::class, array(
                    'class' => User::class,
                    'choice_label' => 'username',
                ))
                ->add('episode', IntegerType::class)
                ->add('photo', TextType::class)
                ->add('photoresume', TextType::class)
                ->add('published', ChoiceType::class, array(
                    'choices' => array(
                        'Oui' => true,
                        'Non' => false,
                    )))
                ->add('submit', SubmitType::class, ['label' => 'Valider'])
            ;
        }
        else{
            $builder
                ->add('name', TextType::class)
                ->add('content', TextareaType::class)
                ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name'])
                ->add('user', EntityType::class, array(
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.username = :username')
                            ->setParameter('username', $this->user);
                        /* $er->createQueryBuilder('u')
                             ->where('u.roles LIKE :roles')
                             ->setParameter('roles', '%"'.$this->user.'"%');*/
                    },
                    'choice_label' => 'username',
                ))
                ->add('episode', IntegerType::class)
                ->add('photo', TextType::class)
                ->add('photoresume', TextType::class)
                ->add('published', ChoiceType::class, array(
                    'choices' => array(
                        'Oui' => true,
                        'Non' => false,
                    )))

                ->add('submit', SubmitType::class, ['label' => 'Valider'])
            ;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Post',
            'user'       => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_post';
    }


}
