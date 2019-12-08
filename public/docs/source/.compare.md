---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: false

toc_footers:
- Developed by <a href='http://opuslabs.in'>Opus Labs</a>
---
<!-- START_INFO -->
# Info

Backend is developed using [Laravel 5.5](https://laravel.com/docs) framework
and APIs are developed following REST principles. For authentication, we are using
firebase. You will need to send the token recieved from firebase in `Authorization` 
header as `Bearer {token}` for authentication purpose.

<!-- END_INFO -->

#Comment


<!-- START_ba1538d0ad06d1cbeb7007aaa0ac507b -->
## List of comments on a post

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/posts/1/comments" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/comments");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_profile_id": {
                "id": 1,
                "name": "Test User",
                "gender": "m",
                "image": ""
            },
            "post_id": 1,
            "text": "Test comment",
            "deleted_at": null,
            "created_at": "2019-12-07 16:52:55",
            "updated_at": "2019-12-07 16:52:55",
            "like_count": 0,
            "dislike_count": 0,
            "liked": 0,
            "disliked": 0,
            "post": {
                "id": 1,
                "user_profile_id": {
                    "id": 1,
                    "name": "Test User",
                    "gender": "m",
                    "image": ""
                },
                "text": "This is a sample post",
                "media_url": "https:\/\/via.placeholder.com\/50",
                "type": "text",
                "share_count": 1,
                "video_thumbnail_url": null,
                "text_location_on_video": null,
                "is_story": 0,
                "deleted_at": null,
                "created_at": "2019-12-07 14:29:27",
                "updated_at": "2019-12-07 16:27:55",
                "title": "Sample post title"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost\/api\/posts\/1\/comments?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/posts\/1\/comments?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/posts\/1\/comments",
    "per_page": "15",
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/posts/{post}/comments`


<!-- END_ba1538d0ad06d1cbeb7007aaa0ac507b -->

<!-- START_b13b9c12bce405a11e471fa805b38e03 -->
## Create a comment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/posts/1/comments" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"text":"est"}'

```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/comments");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "text": "est"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/posts/{post}/comments`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    text | string |  required  | Comment text

<!-- END_b13b9c12bce405a11e471fa805b38e03 -->

<!-- START_454c5c675dcfd4034c2125644e8ed14d -->
## Like a comment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/comments/1/like" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/comments/1/like");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/{comment}/like`


<!-- END_454c5c675dcfd4034c2125644e8ed14d -->

<!-- START_e65dec1cca213e5e8ac9ce5be08b7a89 -->
## Dislike a comment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/comments/1/dislike" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/comments/1/dislike");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/comments/{comment}/dislike`


<!-- END_e65dec1cca213e5e8ac9ce5be08b7a89 -->

#Post


<!-- START_da50450f1df5336c2a14a7a368c5fb9c -->
## List of posts

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/posts?treding=0&user_profile_id=-1&type=text" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts");

    let params = {
            "treding": "0",
            "user_profile_id": "-1",
            "type": "text",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_profile_id": {
                "id": 1,
                "name": "Test User",
                "gender": "m",
                "image": ""
            },
            "text": "This is a sample post",
            "media_url": "https:\/\/via.placeholder.com\/50",
            "type": "text",
            "share_count": 1,
            "video_thumbnail_url": null,
            "text_location_on_video": null,
            "is_story": 0,
            "deleted_at": null,
            "created_at": "2019-12-07 14:29:27",
            "updated_at": "2019-12-07 16:27:55",
            "title": "Sample post title",
            "like_count": 0,
            "dislike_count": 1,
            "comment_count": 1,
            "liked": 0,
            "disliked": 1,
            "commented": 1
        }
    ],
    "first_page_url": "http:\/\/localhost\/api\/posts?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/posts?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/posts",
    "per_page": "15",
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/posts`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    treding |  optional  | optional Show trending posts.
    user_profile_id |  optional  | string Show posts of a users.
    type |  optional  | string Filter posts on the basis of type.

<!-- END_da50450f1df5336c2a14a7a368c5fb9c -->

<!-- START_ea8d166c68ec035668ea724e12cafa45 -->
## Create a new post

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/posts" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"title":"quis","text":"nihil","media_url":"aut","type":"laborum","is_story":true}'

```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "title": "quis",
    "text": "nihil",
    "media_url": "aut",
    "type": "laborum",
    "is_story": true
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/posts`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    title | string |  optional  | optional Title of the post
    text | string |  optional  | optional Text(body) of the post, required if parameter media_url is not set
    media_url | string |  optional  | optional  Media for the post, required if parameter text is not set
    type | string |  required  | Type of the post. Possible values: text, image, video, audio, gif
    is_story | boolean |  optional  | optional  If post is a story. Default value is false

<!-- END_ea8d166c68ec035668ea724e12cafa45 -->

<!-- START_349c2603827140c7622a5b6a9d273445 -->
## List of posts posted by current user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/posts/me" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/me");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 2,
            "user_profile_id": {
                "id": 1,
                "name": "Test User",
                "gender": "m",
                "image": ""
            },
            "text": "This is a sample story",
            "media_url": "https:\/\/via.placeholder.com\/50",
            "type": "text",
            "share_count": 0,
            "video_thumbnail_url": null,
            "text_location_on_video": null,
            "is_story": 1,
            "deleted_at": null,
            "created_at": "2019-12-08 14:12:44",
            "updated_at": "2019-12-08 14:12:44",
            "title": "Sample story",
            "like_count": 0,
            "dislike_count": 0,
            "comment_count": 0,
            "liked": 0,
            "disliked": 0,
            "commented": 0
        },
        {
            "id": 1,
            "user_profile_id": {
                "id": 1,
                "name": "Test User",
                "gender": "m",
                "image": ""
            },
            "text": "This is a sample post",
            "media_url": "https:\/\/via.placeholder.com\/50",
            "type": "text",
            "share_count": 1,
            "video_thumbnail_url": null,
            "text_location_on_video": null,
            "is_story": 0,
            "deleted_at": null,
            "created_at": "2019-12-07 14:29:27",
            "updated_at": "2019-12-07 16:27:55",
            "title": "Sample post title",
            "like_count": 0,
            "dislike_count": 1,
            "comment_count": 1,
            "liked": 0,
            "disliked": 1,
            "commented": 1
        }
    ],
    "first_page_url": "http:\/\/localhost\/api\/posts\/me?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/posts\/me?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/posts\/me",
    "per_page": "15",
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```

### HTTP Request
`GET api/posts/me`


<!-- END_349c2603827140c7622a5b6a9d273445 -->

<!-- START_66cd571eadad5d95ba392eba7959d642 -->
## Get a post by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/posts/1/show" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/show");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "user_profile_id": {
        "id": 1,
        "name": "Test User",
        "gender": "m",
        "image": ""
    },
    "text": "This is a sample post",
    "media_url": "https:\/\/via.placeholder.com\/50",
    "type": "text",
    "share_count": 1,
    "video_thumbnail_url": null,
    "text_location_on_video": null,
    "is_story": 0,
    "deleted_at": null,
    "created_at": "2019-12-07 14:29:27",
    "updated_at": "2019-12-07 16:27:55",
    "title": "Sample post title",
    "like_count": 0,
    "dislike_count": 1,
    "comment_count": 1,
    "liked": 0,
    "disliked": 1,
    "commented": 1
}
```

### HTTP Request
`GET api/posts/{post}/show`


<!-- END_66cd571eadad5d95ba392eba7959d642 -->

<!-- START_a78c203bc38cabcaa6a9cf11a5a21ca5 -->
## Like a post

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/posts/1/like" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/like");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/posts/{post}/like`


<!-- END_a78c203bc38cabcaa6a9cf11a5a21ca5 -->

<!-- START_fa2608832a9bb629272ecd9023259a4d -->
## Dislike a post

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/posts/1/dislike" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/dislike");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/posts/{post}/dislike`


<!-- END_fa2608832a9bb629272ecd9023259a4d -->

<!-- START_9483385756d0404402985a76fe4cc6f0 -->
## Share a post
Share a post, this will increase share count, actually sharing is being handled at client side

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/posts/1/share" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/share");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/posts/{post}/share`


<!-- END_9483385756d0404402985a76fe4cc6f0 -->

<!-- START_97ee9fdaf34cc9db1ebbf12498d634bf -->
## Report a post

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/posts/1/report" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/posts/1/report");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Spam",
    "post_id": 1,
    "user_profile_id": 1,
    "updated_at": "2019-12-08 14:26:38",
    "created_at": "2019-12-08 14:26:38",
    "id": 25
}
```

### HTTP Request
`GET api/posts/{post}/report`


<!-- END_97ee9fdaf34cc9db1ebbf12498d634bf -->

<!-- START_4484de6170229156c9907ae4f3f29dfe -->
## List of users who have posted stories

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/stories/users" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/stories/users");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 1,
        "user_id": "ABZ-TU",
        "name": "Test User",
        "image": "",
        "gender": "m",
        "fcm_registration_id": "dummy-id",
        "notification_on_like": true,
        "notification_on_dislike": true,
        "notification_on_comment": true,
        "is_admin": 0,
        "created_at": "2019-12-07 11:50:25",
        "updated_at": "2019-12-07 11:50:25",
        "is_blocked": 0,
        "is_private": 1
    }
]
```

### HTTP Request
`GET api/stories/users`


<!-- END_4484de6170229156c9907ae4f3f29dfe -->

<!-- START_53e5d47e982eb21ae1b44370f45903da -->
## List of stories by a user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/stories/users/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/stories/users/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[
    {
        "id": 2,
        "user_profile_id": {
            "id": 1,
            "name": "Test User",
            "gender": "m",
            "image": ""
        },
        "text": "This is a sample story",
        "media_url": "https:\/\/via.placeholder.com\/50",
        "type": "text",
        "share_count": 0,
        "video_thumbnail_url": null,
        "text_location_on_video": null,
        "is_story": 1,
        "deleted_at": null,
        "created_at": "2019-12-08 14:12:44",
        "updated_at": "2019-12-08 14:12:44",
        "title": "Sample story"
    }
]
```

### HTTP Request
`GET api/stories/users/{userProfile}`


<!-- END_53e5d47e982eb21ae1b44370f45903da -->

#PostActivity


<!-- START_7651fa39308e031728c794ef2c6be240 -->
## Activities on posts posted by user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/activities" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/activities");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [],
    "first_page_url": "http:\/\/localhost\/api\/activities?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/activities?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/activities",
    "per_page": "15",
    "prev_page_url": null,
    "to": null,
    "total": 0
}
```

### HTTP Request
`GET api/activities`


<!-- END_7651fa39308e031728c794ef2c6be240 -->

#UserProfile


<!-- START_1497ed33b433ac5263898f3caa2548a7 -->
## Create or update profile

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/profile" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"update":"et","name":"dolore","image":"qui","gender":"m or f","fcm_registration_id":"quaerat","notification_on_like":"est","notification_on_dislike":"est","notification_on_comment":"et","is_private":true}'

```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "update": "et",
    "name": "dolore",
    "image": "qui",
    "gender": "m or f",
    "fcm_registration_id": "quaerat",
    "notification_on_like": "est",
    "notification_on_dislike": "est",
    "notification_on_comment": "et",
    "is_private": true
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    update | string |  required  | Update or create profile. Send 1 for update and 0 for create
    name | string |  optional  | optional Name of the user, if not given will retrieved from firebase token
    image | string |  optional  | optional Image of the user, if not given will retrieved from firebase token
    gender | string |  required  | Gender of user.
    fcm_registration_id | string |  required  | One signal id
    notification_on_like | string |  required  | Send notification or not when post is liked
    notification_on_dislike | string |  required  | Send notification or not when post is disliked
    notification_on_comment | string |  required  | Send notification or not on new comment
    is_private | boolean |  required  | Profile is provate or not

<!-- END_1497ed33b433ac5263898f3caa2548a7 -->

<!-- START_66f27d41509c70f40b15c2d93e077f70 -->
## List of followers

> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/profile/followers/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/followers/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": "ABZ-TU",
            "name": "Test User",
            "image": "",
            "gender": "m",
            "fcm_registration_id": "dummy-id",
            "notification_on_like": true,
            "notification_on_dislike": true,
            "notification_on_comment": true,
            "is_admin": 0,
            "created_at": "2019-12-07 11:50:25",
            "updated_at": "2019-12-07 11:50:25",
            "is_blocked": 0,
            "is_private": 1,
            "is_following": 1,
            "following_count": 1,
            "followers_count": 1
        }
    ],
    "first_page_url": "http:\/\/localhost\/api\/profile\/followers\/1?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/profile\/followers\/1?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/profile\/followers\/1",
    "per_page": "15",
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/profile/followers/{userProfile}`


<!-- END_66f27d41509c70f40b15c2d93e077f70 -->

<!-- START_ca133cd1c7b6ea47395e254f684c0659 -->
## List of users current user is following

> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/profile/following/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/following/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "user_id": "ABZ-TU",
            "name": "Test User",
            "image": "",
            "gender": "m",
            "fcm_registration_id": "dummy-id",
            "notification_on_like": true,
            "notification_on_dislike": true,
            "notification_on_comment": true,
            "is_admin": 0,
            "created_at": "2019-12-07 11:50:25",
            "updated_at": "2019-12-07 11:50:25",
            "is_blocked": 0,
            "is_private": 1,
            "is_following": 1,
            "following_count": 1,
            "followers_count": 1
        }
    ],
    "first_page_url": "http:\/\/localhost\/api\/profile\/following\/1?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost\/api\/profile\/following\/1?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost\/api\/profile\/following\/1",
    "per_page": "15",
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/profile/following/{userProfile}`


<!-- END_ca133cd1c7b6ea47395e254f684c0659 -->

<!-- START_7a0e8e9ad1932f551fbf883d023d4b0f -->
## Search profiles

> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/profile/search" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/search");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/search`


<!-- END_7a0e8e9ad1932f551fbf883d023d4b0f -->

<!-- START_34113ea89cf480eb337f2b57e5a14429 -->
## Follow User
Toogle follow state for user.

> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/profile/follow/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/follow/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/follow/{userProfile}`


<!-- END_34113ea89cf480eb337f2b57e5a14429 -->

<!-- START_290fb33c22cf08e436b2fb629bbf1625 -->
## List of follow requests

> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/profile/follow-requests" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/follow-requests");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[]
```

### HTTP Request
`GET api/profile/follow-requests`


<!-- END_290fb33c22cf08e436b2fb629bbf1625 -->

<!-- START_0264f59dcbcd5dc36c18604215f2236c -->
## Send follow request to a private profile

> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/profile/follow-requests/follow/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/follow-requests/follow/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "follow_request": true
}
```

### HTTP Request
`GET api/profile/follow-requests/follow/{userprofile}`


<!-- END_0264f59dcbcd5dc36c18604215f2236c -->

<!-- START_56b76f678fef158ee22f5e741716cbff -->
## Accept/Reject follow request

> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/profile/follow-requests/1/review" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"accept":true}'

```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/follow-requests/1/review");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "accept": true
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/profile/follow-requests/{followrequest}/review`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    accept | boolean |  required  | Accept or not follow request

<!-- END_56b76f678fef158ee22f5e741716cbff -->

<!-- START_c1b9c05f4240dd28519d795314190521 -->
## Show user profile

> Example request:

```bash
curl -X GET -G "http://localhost/weshare/public/api/profile/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json"
```

```javascript
const url = new URL("http://localhost/weshare/public/api/profile/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "user_id": "ABZ-TU",
    "name": "Test User",
    "image": "",
    "gender": "m",
    "fcm_registration_id": "dummy-id",
    "notification_on_like": true,
    "notification_on_dislike": true,
    "notification_on_comment": true,
    "is_admin": 0,
    "created_at": "2019-12-07 11:50:25",
    "updated_at": "2019-12-07 11:50:25",
    "is_blocked": 0,
    "is_private": 1,
    "posts_count": 1,
    "like_count": 0,
    "dislike_count": 1,
    "comment_count": 1,
    "is_following": 1,
    "is_follow_requested": 0,
    "following_count": 1,
    "followers_count": 1
}
```

### HTTP Request
`GET api/profile/{userProfile}`


<!-- END_c1b9c05f4240dd28519d795314190521 -->

<!-- START_2b8fcce3d649efd30dc5ddb0ea0b0c73 -->
## Report a user

> Example request:

```bash
curl -X POST "http://localhost/weshare/public/api/report/1" \
    -H "Authorization: Bearer {token}" \
    -H "Content-Type: application/json" \
    -d '{"message":"quos"}'

```

```javascript
const url = new URL("http://localhost/weshare/public/api/report/1");

let headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "message": "quos"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/report/{reportUser}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    message | text |  required  | Reason for reporting

<!-- END_2b8fcce3d649efd30dc5ddb0ea0b0c73 -->


