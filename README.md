# OpenWhisk_Project

Create a Function-as-a-Service (FaaS) environment using OpenWhisk

## Description

The goal of our project is to create a Fonction-as-a-service (FaaS) environment using OpenWhisk. Moreover, codes written in Java, Python, Node.js and PHP and external resources such as RabbitMQ and MariaDB must be supported by our FaaS environment.

## Requirements

To build and run the project, you need to have on your machine :

 - VirtualBox 
	
	VirtualBox is a virtualization software. It allows to create virtual machines.
	You need to download VirtualBox on your machine (`https://www.virtualbox.org/`).
	
 - Minikube
	
	Minikube is a tool that makes it easy to run Kubernetes locally. Minikube runs a single-node Kubernetes cluster inside a VM on your laptop.

 - Kubectl
	
	Kubectl is a command line interface for running commands against Kubernetes clusters.
	
 - Helm
	
	Helm is a tool to simplify the deployment and management of applications on Kubernetes clusters.

 - OpenWhisk CLI (wsk)
		
	The OpenWhisk CLI (wsk) is the Command Line Interface offered by OpenWhisk. It allows to easily create, run and manage OpenWhisk entities.
	

To obtain the Minikube, Kubetcl, Helm and OpenWhisk CLI (wsk) executables, you can download the GitHub project `https://github.com/ValentinVr/OpenWhisk_Project` and unzip the executables in the corresponding folder. You can also download these executables on Internet.
		
Then, you can simplify accesses to the Minikube, Kubectl, Helm and OpenWhisk CLI (wsk) executables by adding binary file `OpenWhisk_Project/executables` in your PATH environment variable.

## Building & Running

To run the project, you need to open a terminal on your machine.

Then, you need to configure the Minikube virtual machine. For this, run the following commands.

`minikube config set kubernetes-version v1.10.5`
`minikube config set cpus 2`
`minikube config set memory 4096`
`minikube config set WantUpdateNotification false`

Next, you can start Minikube.

`minikube start`

This step take a few minutes. To continue, you must check the Minikube virtual machine is correctly running. The following command must show you that host, kubelect and apiserver are running and kubectl is correctly configured, so pointing to minikuve-vm.

`minikube status`

When the Minikube virtual machine is correctly running, you need to run the following command to put the docker network in promiscuous mode.

`minikube ssh -- sudo ip link set docker0 promisc on`

Then, you need to run the following command to install Tiller, the Helm server, to your running Kubernetes cluster.

`helm init`

This step take a few seconds. To continue, you must check the tiller-deploy pod in the kube-system namespace is running when you run the following command.

`kubectl get pods -n kube-system`

Then, you can run the following command to create a clusterrolebinding.

`kubectl create clusterrolebinding tiller-cluster-admin --clusterrole=cluster-admin --serviceaccount=kube-system:default`

Then, you must indicate the Kubernetes worker nodes that should be used to execute user containers by OpenWhisk's invokers.

`kubectl label nodes --all openwhisk-role=invoker`

Now, you must change directory of your terminal to be in `OpenWhisk_Project/deployment` folder. Then, you can deploy OpenWhisk using Helm with the following command.

`helm install . --namespace=openwhisk --name=isep -f mycluster.yaml`

This step take a few minutes. To continue, you must check the install-package pod in the openwhisk namespace is completed.

`kubectl get pods -n openwhisk`

If you want to see more information about the OpenWhisk deployment progress, you can run the following command.

`helm status isep`

When the install-package pod in the openwhisk namespace is completed, you can configure your OpenWhisk CLI (wsk).

`wsk -i property set --apihost 192.168.99.100:31001`
`wsk -i property set --auth 23bc46b1-71f6-4ed5-8c54-816aa4f8c502:123zO3xZCLrMN6v2BKK1dXYFpXlPkccOFqm12CdAsMgRU4VrNZ9lyGVCGuMDGIwP`

Now, you can test your OpenWhisk deployment with the following command.

`helm test isep`

If the two tests passed, then your OpenWhisk FaaS environment is correctly deployed.

## Usage

Now, you are able to use your OpenWhisk FaaS environment.

To test your environment, you can create a simple action using the file `functions/js/test.js`. This file contains a simple node.js function which takes an argument and returns a JSON object.

`wsk -i action create testJS functions/js/test.js`

Then you can check if your action is correctly created.

`wsk -i list`

Normally, your action is visible. Then you can easily invoke your action.

`wsk -i action invoke testJS --param param Thierry --result`

Therefore you see the action result with the given argument.

In the same way, you can create your own actions and then invoke them. Your actions can be created from code written in Java, Pyhton, Node.js, PHP and others languages.

Moreover, you can create rules and triggers to invoke your actions when a given event occurs. These events can used external resources.

## GitHub repoository

`https://github.com/ValentinVr/OpenWhisk_Project`