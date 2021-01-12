# 코드 개선사항 리뷰..

1. route를 web이 아닌 api를 사용하기 위해 passport 이용

2. auth:api와 Route:apiResources를 통하여 데이터 전송

3. vue.js에서 데이터를 보낼 때 삭제한다고 하면

이거는 spa + game에 적용되어 있는 데이터 전송

```
async deleting(data){
                 const res = await this.callApi('delete', 'api/record/delete',{'record_id': recordId})

                if(res.status==200)
                {
                      this.i(res.data.msg);    
                }
                else{
                    this.swr();
                } 
            },
```

```
async callApi(method, url, dataObj){
            try{
               return await  axios({
                    method:method,
                    url:url,
                    data : dataObj
                });
            }catch(e){
                return e.response
            }
        },
```

이거는 facebook에서 vuex를 사용한 데이터 전송..

```
 axios.post('/api/friend-request-response', { 'user_id':userId, 'status':1 })
            .then(res => {
                commit('setUserFriendship', res.data);
            })
            .catch(error => {

            })
```

vue쪽에서 어떤 방식으로 데이터를 보내줘야 할지는.. 사실 내가 지금 고민할 문제는 아닌 것 같다 백엔드가 우선이니까

보내고 받고만 잘하자 위에 SPA방식으로..

4. AttackController에서 Service와 Repository를 이용하기 위해서는..?

Attack이라는 행위에 대해서 데이터베이스가 필요하지 않기 때문에 migration을 안 한다고 하면..

AttackController에서 하는 Action을 Attack 레포지토리에 담는다고 하면..

AttackRepository와 AttackRepositoryInterface가 있으면

AttackRepositoryInterface는 Attack에 대한 행위들을 정리..

heal, attack, skill 1~4, update, save, message

Attack이라는 모델을 만들어서.. ? Repository를 만들어서?

각 액션에 대한 행동변화는 

HP 증가, HP 감소, EXP 증가, EXP 감소, Level 증가, Level 감소 

연계되는 것은 EXP가 올라가면서 LEVEL이 증가되고 HP가 MAX로 가득차는 경우

HP가 0보다 작아지면서 LEVEL이 감소되고 그에 맞는 EXP로 초기화 되는 경우

리포지터리 : https://blog.decorus.io/php/2018/07/04/laravel-dependency-injection-container.html

리포지터리 : https://ichi.pro/ko/laravel-ioc-mich-lipojitoli-paeteon-183595565877403

리포지터리 : https://heera.it/laravel-repository-pattern

서비스 - 리포지터리 : https://dev.to/jsafe00/implement-crud-with-laravel-service-repository-pattern-1dkl

서비스 - 리포지터리 : https://stackoverflow.com/questions/60029955/when-to-use-repository-vs-service-vs-trait-in-laravel

interface에 구현되어야 하는 기능들..?

Reset

Save

Heal

User의 데이터를 변화시키는 행동인데 Attack이라는 컨트롤러가 필요할까?

여기서부터 접근이 잘못된 것 같다.

AttackRepository가 아니라.. UserRepository와 UserService로 접근을 한다면?

비즈니스 로직은 서비스..



