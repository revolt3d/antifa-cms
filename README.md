# DRAFT December 22, 2022 THIS IS NOT COMPLETE

These are instructions to build a website using existing off-the-shelf software and no programming skills. This recipe builds out more than merely a website. In the end, you will have a complete content management and publishing system.

## About Me

I'm a software engineer. I've been building web applications and websites for more than 20 years. I'm old as hell. Over the years, I've learned a few things. One of those things I've learned is how to build a really simple website, requiring essentially no programming skills whatsoever, extremely efficient, cost-effective and fast.

I'm sharing this knowledge with people because creating a simple website is really really expensive. And figuring out how to write code is really time-consuming. With these instructions, you will be able to create a legit website in a few days of tinkering. If you know what you're doing, you can set all of this up in a matter of a couple of hours. 

## Getting Started

I will be the first to admit that this recipe is not the only way to accomplish what I'm describing here. All I'm saying is this how I do it, and it works really well.

The goal of this process is to create a robust content management system to support a public website with no programming required and extremely low hosting costs.

To make all of this cost-effective, and low-tech, we're going to use a bunch of off-the-shelf tools to make it all work for us. We're going to use GitHub.com as our content management tool. We're going to use a super-fast content management system written in PHP called Pico CMS. And we're going to use some simple Linux commands to glue it all together. That last part is a bit technical, but it's not hard to pull off.

### Level 0
Level 0 is the part of the tutorial that is the easiest for non-technical people to consume. In Level 0, I do everything via GitHub.com in terms of managing content - adding stories, editing stories, or whatever it is plan to publish. 

Level 0 still requires that I setup a public server to run my website. For antifa-cms, that's not a huge lift, but for a non-technical person, it will be the most difficult  part to accomplish. One caveat is that you don't have to use an Amazon EC2 to run antifa-cms. The only requirements are that wherever you run antifa-cms, the server needs to support PHP, and you need some way to connect to it either via SSH or at least have some access to the server's crontab. I recommend going through this tutorial using an Amazon EC2, if you want to switch later, it will be easy for you to figure out how to make it work. 

### Level 0: Requirements

1. GitHub.com account
2. An Amazon AWS account
3. A laptop or desktop computer that has an SSH client installed

### Level 0: Your Computer Setup

In Level 0, the only thing you need to be able to do is SSH to your Amazon EC2 and a web browser.

On your laptop or desktop, open a terminal and type the following command

```
ssh -V
```

If that command shows an error, you need to install SSH. How do you install SSH on a Mac? I have no idea, it should be installed, if it's not, you either have a really, really old Mac or removed SSH for some reason. Linux users should know how to install SSH. Windows users will need to figure it out.

### Level 0: Create The Webserver

Creating an Amazon EC2 is easy. It's a couple of clicks. But making it work entirely as a web server will require a bit of work. 

We're going to create a tiny EC2 that for most of you will fall into the free tier. If your website gets famous, you might have to pay Amazon some money. For context, I run a webserver with 4 websites on it and it costs me $20 a month. The traffic isn't high, but a tiny website could end up costing like $2 a month. 

1. Login to [aws.amazon.com](https://aws.amazon.com/). If you don't have an account, you need to create one.
2. Create an EC2.
3. Point your domain name at your newly created EC2
4. Configure SSL
5. Install antifa-cms
6. Create your own content
7. Setup Auto-publish

#### Login to Amazon AWS

This step is pretty easy, if you don't already have an Amazon AWS account, you need to create one. [aws.amazon.com](https://aws.amazon.com).

Once you've created your and verified that you can login to Amazon AWS, continue to the next step.

#### Create an Amazon EC2

You have an AWS account and you're logged in as the Root user, not an IAM user.

Click "Services" and select "Compute."

![AWS Services Menu Screenshot](assets/aws-services-menu.jpg)

After you click "Compute" a sub-menu should display with an "EC2" option, click that.

![AWS Services Computer EC2 Menu Screenshot](assets/aws-compute-ec2.jpg)

There's guarantee you will see what I see when I click on the EC2 option, but you should see something on your screen that says "Launch Instance" - click that. By "instance," they mean an EC2.

![AWS Launch Instance Screenshot](assets/aws-launch-ec2.jpg)

Now you need to name your instance. It really doesn't matter what you name it, but it should probably make sense based on what we're setting up. If your website is about butterflies, you name it "My Butterfly Webserver."

![AWS Name Instance Screenshot](assets/aws-launch-ec2-name.jpg)

The next section is selecting the operating system your EC2 will use. You need to select Ubuntu. It doesn't matter if the version you select doesn't match what's in the below screenshot, whatever is the most current version will work.

![AWS EC2 OS Screenshot](assets/aws-ec2-ubuntu.jpg)

The rest of the options for creating an EC2 can be the default values.

The t2.micro is fine for the type of EC2. 

You do need to create an SSH key pair for logging into your new EC2 instance. We're going to connect using SSH, and this is required to make that work.

![AWS EC2 Key Pair Screenshot](assets/aws-ec2-key-pair.jpg)

You can leave all of the defaults as they are when creating a key pair, you do need to provide a name. The name doesn't really matter, you can name it something like "My Keys."

![AWS EC2 Key Pair Options Screenshot](assets/aws-ec2-key-pair-options.jpg)

Under Network Settings, all of the defaults will work, but check the boxes for allowing HTTPS and HTTP. 

![AWS EC2 Network Settings Screenshot](assets/aws-ec2-network-settings.jpg)

Everything else can be the defaults. For storage, you can crank it up to 30GB and still fall into the free tier, but honestly 8GB is probably fine.

Click "Launch Instance."

It will take a few minutes to create the new EC2 instance. If you click on "Instances" in the left side navigation in the AWS dashboard, you should see your new instance. The Status Check will take a few minutes to show green, but the instance should get built fairly quickly. 

Before we move on, let's verify that you can SSH into that new EC2. 

Click "Instances," check the checkbox for your new EC2 and click the "Connect" button. This won't actually connect you, but it will show you how to connect to your new EC2 instance.

Assuming that you have the private key from when you launched your instance, and you have that pem file saved on your laptop or desktop, the "Example" command should work.

For my instance, I created a pem called 12300.pem. It doesn't mean anything - the 12300 - it's just a number I made up. I have that file 12300.pem stored in on my laptop in ~/.ssh.

So when I want to connect to one of my EC2, I could do something like this.

```
ssh -i "~/.ssh/12300.pem" ubuntu@ec2-33-321-211-321.compute-1.amazonaws.com
```

If you did everything right, and I explained everything correctly, you should just login with a command similar to that ssh command. You shouldn't be prompted for a password, the key pair is the authentication method.

If this didn't work, you need to go back to your key pair and make sure that's correct. You can delete and create key pairs. You can throw the EC2 you created in the trash and start over. I do that all the time. 

To trash an EC2, first change it's state to stopped, and then terminate it. Even after we build an EC2 and set all of it, there is nothing on the EC2 that we care about. All of our code and content is managed via GitHub.com. So if the server dies unexpectedly, yes, the website will be down, but no data will be lost. 

That's one of the great things about this setup for a website is that the actual webserver is disposable. And you really don't need to use Amazon AWS. You can literally run this on any webserver that can serve up PHP. So don't lock yourself in to Amazon because I happened to use it in this tutorial. I use AWS because I'm familiar with it. I personally hate Google and will never use Google Compute, but there are many options out there better than Amazon.

#### Configure the EC2 to be a Webserver

By default a new EC2 doesn't do jack. It's just a barebones server that you can connect to via SSH. Do that, connect via SSH and run the following commands.

The first thing you need to do is become root. The root user can do anything, particularly install and upgrade system packages, which is what we're going to do.

```
sudo su -
```

Whenever I setup a new instance, I make sure all of the packages on the box are up-to-date. To do that run the following command.

```
apt-get update;apt-get upgrade;
```

If you get asked any questions, just accept the default unless you know that doing so would be dumb.

When the updates are done, and that shouldn't take long on a new EC2, install PHP.

```
apt-get install php
```

Doing so will also install a bunch of other stuff like the Apache webserver, we want those things. So type 'y' when you are asked to continue.

```
Do you want to continue? [Y/n] y
```

When PHP finishes installing, you should have a working webserver. It won't be working the way we want it to work, but it should work.

To test that the webserver is working, find your public IP address by looking at your instance details in the AWS dashboard. I'm specifically not telling you precisely how to find this information in the AWS dashboard because you need to be comfortable navigating the dashboard. 

If your public IP address is 43.031.301.90, in your web browser go to

```
http://43.031.301.90
```

Note that this time, you don't want to use https. Your browser force you to use https, but it worn't work, yet. Right now, SSL is not configured on your server, so https will fail. 

If your webserver is working, you should see something like this.

![Apache Default Webserver Page Screenshot](assets/aws-apache-default.jpg)

If it's not working, you need to figure that out.

Some things to check.

1. Is the EC2 running and can you SSH into it?
2. If you can SSH, run 'sudo su -' followed by 'ps aux | grep apache' You should see apache processes running.

![Apache procs running terminal output Screenshot](assets/aws-apache-procs.jpg)

If you don't see any apache2 processes running, you need to start apache. To do that, run this command as root (that's the 'sudo su -' command).

```
/etc/init.d/apache2 start
```

You can also run stop and restart apache whenever you need to.

```
/etc/init.d/apache2 stop
```

```
/etc/init.d/apache2 restart
```

If you still can't see the default apache webpage, and everything seems to be running, I don't have any more tips. You need to search for solutions on your own, using Stackoverflow or something.

#### Install antifa-cms
Because of how Git works, let's create a fork of the antifa-cms. The reason for forking, rather than just cloning the repo, is that we want to do our own commits to our forked repo. If we don't fork antifa-cms, we would be pushing our content and theme changes to that repo, which wouldn't work. I would reject those change requests as inappropriate.

I want you to fork the antifa-cms repo, creating your own copy of antifa-cms that you manage yourself. If I make changes to the main antifa-cms, you can update your fork whenever you choose to do so, but that's all down the road.

Login in to GitHub.com and fork [antifa-cms](https://github.com/revolt3d/antifa-cms).

Look for the Fork button in the upper right of the repo page.

Here's what the fork screen looks like. 

![GitHub.com Fork Screen Screengrab](assets/antifa-cms-fork.jpg)

Accept all of the defaults, but you should name the forked repo something that relates to what you're actually doing with your website. For instance, if your website is about Antifascist Political Philosophy, call the repo 'antifa-poli-sci' or something like that. If it's about the migratory patterns of monarch butterflies, you call name is 'monarch-butt'. 

It really doesn't matter what you name the forked repo, but it needs to make sense to you, and if you're going to collaborate with others, it needs to make sense to them.

I'm going to assume all of the forking went as planned and now you're staring at your new forked repo. 

You need to put that forked repo on your new EC2, and you're going to do that with git. This is different than GitHub.com. GitHub.com is built on top of git. The real genius is in git, GitHub.com is just convenient. Technically, you can do all of this without GitHub.com, but I want to leverage GitHub.com as the user interface to our cms to publish new content, or change and delete existing content.

To install the forked antifa-cms repo on our new EC2 server, we first need to SSH into the EC2 instance and 'sudo su -' to become root.

This part could get a little technical, so take it slow.

As an overview for what we're about to do is that we're going to configure our Apache webserver to run our forked antifa-cms code, instead of that default Apache web page we saw earlier. To do this, we're going to run a few commands from the command-line on our EC2 as root.

Just delete the entire html directory, we don't need it.

```
cd /var/www; rm -rf html;
```

Now clone our forked antifa-cms into the /var/www/ directory. The clone command will look something like this. You will need to adjust it for your repo name.

```
git clone https://github.com/hack3r3d/test-cms.git
```

I recommend using the https GitHub.com URL. There's an SSH one too, but this will suffice for what we're doing, which is only pulling from GitHub.com to the server. We won't be editng files on the server and pushing them to the repo - it's one-directional.

To find the https URL for your repo, click the "Code" button.

![GitHub.com Clone Screengrab](assets/antifa-cms-clone.jpg)

Now back to the server and our SSH client as the root user our freshly cloned repo.

For this next step, we are going to need composer installed. Composer is a package manager for PHP packages. What that means is that it allows us to install stuff, including our cms repo.

```
apt-get install composer
```

That should install composer and all of its dependencies.

Looking back at the clone command, If I used that exact command to clone a repo named test-cms in the /var/www directory, there would be a test-cms directory in the /var/www directory. Let's change directories to /var/www/test-cms directory.

```
cd /var/www/test-cms
```

Now run the composer to setup the antifa-cms system.

```
composer update
```

Because we're running this as the root user, composer will warn us about it. It's OK, just type 'yes'. We will fix this problem in a bit. For now, let's see if we can make the cms run.

We removed the default html directory and created a new directory under /var/www for our cms. Now we need to configure apache to know about our new cms code, and use it instead of the form html directory, that we deleted.

We're going to use an application called vi. This is an editor you should become familiar with, if you haven't already. 

Open the apache server configuration file.

```
vi /etc/apache2/sites-enabled/000-default.conf
```

Move the cursor to the line: DocumentRoot /var/www/html

Remove the html part by pressing 'x' 4 times when the cursor is on the 'h.' Once the html is removed, no press the 'i' key and type the directory where you cloned the cms repo. In our example, that would be test-cms.

Once you've change the DocumentRoot to the correct directory location, save the document in vi. To do that, press ESC once, type a color ':' followed by the letter wq and press enter. 

If you find vi to be frustration, some people like pico instead. To open your apache config using pico, run this command.

```
pico /etc/apache2/sites-enabled/000-default.conf
```

Pico is more user-friendly, but I just prefer vi.

Save your config changes and restart apache. 

``` 
/etc/init.d/apache2 restart
```

Now if you reload the webpage you had pointing to your EC2 public IP address, you should see the default antifa-cms home page.

```
http://43.031.301.90
```

![antifa-cms default home page screenshot](assets/antifa-default-home.jpg)

#### Point your domain

Technically you don't have to do this, you could just access your website with the random Amazon AWS domain, but I'm assuming that we're building a real website here.



#### Configure SSL

#### Install antifa-cms

#### Create your own Content

#### Setup auto-publish
It's the crontab thing.

### Level 0: SSL Certificate

For this tutorial, I'm going to use a free SSL certificate from Let's Encrypt. Unless you plan on going big time big with your website, the Let's Encrypt free cert might be good enough. There are rate limits on these certs.

If you want to purchase your own cert, I purchase SSL certificates from this company called ssls.com. A cheap cert can be as little like $4 a year. These are low assurance certificates, which means they will encrypt data, but the end user doesn't have a ton of confidence in the webserver running that cert or you. 

Honestly, most people aren't going to care which SSL cert you use. However, if you skip the SSL cert and just run your website unencrypted, you will get penalized by search engines and many browsers will flag your website is potentially dangerous, and not in a good way.


## Level 1 [Optional]

If you want to really get into building your website, or building websites for other people using antifa-cms, you will want to setup a local development environment on your laptop or desktop computer. I only use Mac, so these instructions are assuming you have a Mac. If you are running Linux, you should be able to accomplish this phase. If you are in Windows, I have no doubt that what I'm describing here is possible on Windows, I just simply would have no idea how to do it.

### Requirements

Here are your ingredients.

  1. Computer for local development
  2. Docker for local development
  3. Github account (non-professional will work with a caveat - see below)
  4. Amazon AWS account for production deployment to an EC2

## Vocabulary

This guide is meant for everyone, particularly non-technical people who need a low cost website. Below are some definitions to help those who need the help.

### Amazon AWS

In this tutorial, we're going to use Amazon AWS. There are other providers of such services, but AWS is the most familiar to me. I've used Google Compute before, and it works, but I loathe Google as a company. Amazon isn't much better, but it's fine for our purposes. All of these instructions, besides setting AWS infrastructure should be the same.

### Computer

You will need a computer to build your content management system. This is where the bulk of the work is done. The computer you use should be running Mac or Linux. I'm certain these instructions would work with Windows, but I haven't used Windows in many, many years.

### Content Management System

A content management system does what it sounds like it would do - a system that manages content. In this context, content is a web page. Content could also include images that are diplayed on the web page. A content management system makes managing the web pages (e.g. content) easier.

That's what we're building here - a content management system with publishing capabilities.

### Docker

Docker is this amazing tool that you run on your computer that let's you spin up virtual servers on your computer. These little servers run pretty much like a real server will operated. We will use Docker for testing and publishing content.

This part of the process does potentially get technical, if something doesn't work correctly.

### Github
For this recipe you need a GitHub.com account. 

#### Can I use a free GitHub.com account?

The short answer is, and the long answer is maybe. It comes down to whether you want a private repository for your website code and content, or is a public repo OK? Without a paid subscription to GitHub.com, all of your code repositories are public. What that means is that anyone on GitHub.com can see your code repository. They can even propose changes to your repository, but you can just reject them if the changes aren't useful. For all intents and purposes, no one is likely to care about your GitHub.com repository. If it matters to you that your website code not be in a public repository, then pay GitHub.com $4 a month for a professional account and create a private repo.

### Markdown

Markdown is a simple document formatting standard. It is what this file you are reading is written. You can learn more about Markdown [here](https://www.markdownguide.org/cheat-sheet/). What's great about using markdown to build new web pages - to add more content - is that it completely separates the presentation from the content. In Markdown we can structure our story content to be positioned or appear a certain way, but how that will actually be made to look like it's supposed is handled by the theme. So if you want to find where the HTML is for antifa-cms, it's in the themes/antifa-cms-theme directory. Everyone is encouraged to create their own themes, or use one of the already built Pico CMS themes found [here](https://picocms.org/themes/). Because antifa-cms is based on Pico CMS, any of those themes should work fine.

### Linux

Linux is an open source operating system. In terms of running websites - most web servers are running some version of Linux.

### PHP

PHP is a web scripting language. It runs on the webserver. It parses PHP scripts and generates HTML for a user's browser. In this context, PHP is parsing Markdown that we write to render HTML web pages.

### Theme

The theme in antifa-cms is where the design of the website is implemented. This where the HTML and the CSS files are located. Poke around at the very simle antifa-cms-theme, and check out the available Pico CMS [themes](https://picocms.org/themes/). Pico CMS has some minimal documentation about themes [here](https://picocms.org/docs/#themes). 

### Twig

The themes use the Twig templating system. Twig is a really a powerful and major templating system. If you decide to build your own theme, or if you want to modify an existing theme, you should know the basics of Twig. Twig lets you do a lot. The Twig documentation is available [here](https://twig.symfony.com/doc/).
