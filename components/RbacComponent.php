<?php
namespace app\components;


use Exception;
use Yii;
use yii\base\Component;
use app\rbac\AuthorActivityRule;

class RbacComponent extends Component
{
    const ROLE_USER='user';
    
    /**
     * @return \yii\rbac\ManagerInterface
     */
    public function getAuthManager() {
        return Yii::$app->authManager;
    }
    
    /**
     * @throws Exception
     */
    public function generateRules() {
        
        $authManager = $this->getAuthManager();
        $authManager->removeAll(); // удаляем все роли и задания
        
        $admin = $authManager->createRole('admin');
        $user  = $authManager->createRole('user');
        $guest = $authManager->createRole('guest');
        $artist = $authManager->createRole('artist');
        
        $authManager->add($admin);
        $authManager->add($user);
        $authManager->add($guest);
        $authManager->add($artist);
        
        $authorActivityRule = new AuthorActivityRule();
        $authManager->add($authorActivityRule);
        
        $authorActivityPermission = $authManager->createPermission('authorActivity');
        $authorActivityPermission->description = 'Автор (создатель) арт-объекта';
        $authorActivityPermission->ruleName = $authorActivityRule->name;
        
        $authManager->add($authorActivityPermission);
        
        $createActivity = $authManager->createPermission('createActivity');
        $createActivity->description = 'Создание арт-объекта';
        
        
        $viewActivity = $authManager->createPermission('viewActivity');
        $viewActivity->description = 'Просмотр арт-объекта';
        
        $viewEditAllActivity = $authManager->createPermission('viewEditAllActivity');
        $viewEditAllActivity->description = 'Просмотр и редактирование всех  арт-объектов';
        
        $authManager->add($viewEditAllActivity);
        $authManager->add($createActivity);
        $authManager->add($viewActivity);
        
        // наследники ролей
        $authManager->addChild($guest,$viewActivity);
        
        $authManager->addChild($user,$guest);
        $authManager->addChild($user,$createActivity);
        $authManager->addChild($user,$authorActivityPermission);
        
        $authManager->addChild($admin,$user);
        $authManager->addChild($admin,$viewEditAllActivity);
        
        // при регистрации  нового пользователя назначение user  или artist происходит после валидации
        // А админа генерим ручками сейчас (для созданного пользователя), пока нет админки
        
        $authManager->assign($admin,101);
        
    }
    
    /**
     * Присвоение роли пользователю
     * @param $role_name
     * @param $user_id
     * @return bool
     * @throws Exception
     */
    public function assignRole($role_name,$user_id){
        $userRole = Yii::$app->authManager->getRole($role_name);
        // \Yii::$app->authManager->assign($userRole, Yii::$app->user->getId());
        if(!$userRole){
            throw new Exception('Role '.$role_name.' not exist');
        }
        if($this->getAuthManager()->assign($userRole, $user_id)){
            return true;
        }
        return false;
    }
    
    public function assignUserRole($user_id){
        return $this->assignRole(self::ROLE_USER,$user_id);
    }
    
}
