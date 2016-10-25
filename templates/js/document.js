function f(){
    document.getElementById('getBox').className = 'hide';
    document.getElementById('postBox').className = 'hide';
    document.getElementById('putBox').className = 'hide';
    document.getElementById('delBox').className = 'hide';

    document.getElementById('get').className = 'tab-menu-li';
    document.getElementById('post').className = 'tab-menu-li';
    document.getElementById('put').className = 'tab-menu-li';
    document.getElementById('del').className = 'tab-menu-li';
}

document.getElementById('get').onclick=function(){
    f();
    document.getElementById('getBox').className = '';
    this.className = 'tab-menu-li selected';
}

document.getElementById('post').onclick=function(){
    f();
    document.getElementById('postBox').className = '';
    this.className = 'tab-menu-li selected';
}

document.getElementById('put').onclick=function(){
    f();
    document.getElementById('putBox').className = '';
    this.className = 'tab-menu-li selected';
}

document.getElementById('del').onclick=function(){
    f();
    document.getElementById('delBox').className = '';
    this.className = 'tab-menu-li selected';
}
