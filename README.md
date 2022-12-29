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
Describe that.

#### Create an Amazon EC2
Describe that

#### Point your domain
Describe that

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
